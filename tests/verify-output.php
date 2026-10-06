<?php

declare(strict_types=1);

/** Stop fixture verification with the failing contract in the diagnostic. */
function requireValid(bool $condition, string $message): void
{
    if (!$condition) {
        throw new RuntimeException($message);
    }
}

/** Collapse URL dot segments before checking paths, including targets that do not exist. */
function normalizePath(string $path): string
{
    $segments = [];
    foreach (explode('/', $path) as $segment) {
        if ($segment === '' || $segment === '.') {
            continue;
        }
        if ($segment === '..') {
            array_pop($segments);
            continue;
        }
        $segments[] = $segment;
    }

    $normalized = '/' . implode('/', $segments);

    return str_ends_with($path, '/') && $normalized !== '/' ? $normalized . '/' : $normalized;
}

/**
 * Resolve local references against the page's effective base; exclude network resources.
 *
 * @return array{path: string, fragment: string}|null
 */
function localTarget(string $base, string $reference): ?array
{
    $parts = parse_url($reference);
    requireValid($parts !== false, "Invalid link: {$reference}");
    if (isset($parts['host']) || (isset($parts['scheme']) && $parts['scheme'] !== 'file')) {
        return null;
    }

    $path = rawurldecode($parts['path'] ?? '');
    if ($path === '') {
        $path = $base;
    } elseif (!str_starts_with($path, '/')) {
        $directory = str_ends_with($base, '/') ? $base : dirname($base) . '/';
        $path = $directory . $path;
    }

    return [
        'path' => normalizePath($path),
        'fragment' => rawurldecode($parts['fragment'] ?? ''),
    ];
}

/** Verify shared assets, reading controls and original examples in every generated fixture page. */
function verify(string $output): void
{
    $pages = [];
    $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($output, FilesystemIterator::SKIP_DOTS));
    foreach ($files as $file) {
        if ($file->isFile() && $file->getExtension() === 'html') {
            $pages[] = $file->getPathname();
        }
    }
    sort($pages);
    requireValid($pages !== [], 'No generated HTML');
    $codeSamples = [];

    foreach ($pages as $source) {
        $document = new DOMDocument();
        $previous = libxml_use_internal_errors(true);
        try {
            requireValid($document->loadHTMLFile($source, LIBXML_NONET), "Invalid HTML: {$source}");
        } finally {
            libxml_clear_errors();
            libxml_use_internal_errors($previous);
        }
        $xpath = new DOMXPath($document);
        $codeSamples[$source] = [];
        foreach ($xpath->query('//pre/code') as $code) {
            $codeSamples[$source][] = trim($code->textContent);
        }
        $ids = [];
        foreach ($xpath->query('//*[@id]') as $element) {
            $ids[$element->getAttribute('id')] = true;
        }
        requireValid($xpath->query('//input[@type="search" and @aria-label="Search documentation"]')->length > 0, "Search label missing: {$source}");
        requireValid(isset($ids['content']), "Reading target missing: {$source}");

        $baseElement = $xpath->query('//base[@href]')->item(0);
        $base = localTarget($source, $baseElement?->getAttribute('href') ?? './');
        requireValid($base !== null, "External base URL: {$source}");
        foreach ($xpath->query('//img[@src] | //script[@src] | //link[@href]') as $element) {
            $href = $element->getAttribute($element->tagName === 'link' ? 'href' : 'src');
            $target = localTarget($base['path'], $href);
            // Optional graph writers own their artifacts; this checks shared template assets.
            if ($target === null || !preg_match('~^' . preg_quote($output, '~') . '/(?:css|js|images)/~', $target['path'])) {
                continue;
            }
            requireValid(is_file($target['path']), "Missing asset: {$href} in {$source}");
        }

        $anchors = $xpath->query('//a[contains(concat(" ", normalize-space(@class), " "), " ff-skip-link ") or @id="back-to-top"]');
        requireValid($anchors->length === 2, "Reading anchors missing: {$source}");
        foreach ($anchors as $anchor) {
            $href = $anchor->getAttribute('href');
            $target = localTarget($base['path'], $href);
            requireValid($target !== null && $target['path'] === $source, "Reading anchor leaves page: {$href} in {$source}");
            requireValid(isset($ids[$target['fragment']]), "Reading anchor is missing: {$href} in {$source}");
        }

        $toggles = $xpath->query('//button[@data-reading-theme-toggle]');
        requireValid($toggles->length === 1, "Theme toggle missing: {$source}");
        $toggle = $toggles->item(0);
        requireValid($toggle->getAttribute('type') === 'button' && $toggle->hasAttribute('hidden'), "Theme toggle must progressively enable: {$source}");
        requireValid($toggle->getAttribute('aria-label') === 'Switch to navy theme' && $toggle->getAttribute('title') === 'Switch to navy theme', "Theme action label missing: {$source}");
        requireValid(!$toggle->hasAttribute('aria-pressed'), "Theme action must not expose a toggle state: {$source}");
        requireValid(trim($toggle->textContent) === '', "Theme toggle must be icon-only: {$source}");
        requireValid($xpath->query('.//*[local-name()="svg" and @aria-hidden="true"]', $toggle)->length === 2, "Theme icons missing: {$source}");
    }

    $template = dirname(__DIR__);
    foreach (['fast-forward-logo-dark.svg', 'dash-reading.png'] as $name) {
        $original = $template . '/data/' . $name;
        $generated = $output . '/images/' . $name;
        requireValid(is_file($original) && is_file($generated), "Identity asset missing: {$name}");
        requireValid(hash_file('sha256', $original) === hash_file('sha256', $generated), "Identity asset differs: {$name}");
    }
    requireValid(is_file($output . '/index.html'), 'Root guide not generated');
    requireValid(is_file($output . '/guides/installation.html'), 'Nested guide not generated');
    requireValid(is_file($output . '/classes/FastForward-Documentation-Example.html'), 'API not generated');
    $guide = $codeSamples[$output . '/guides/installation.html'];
    requireValid(in_array('composer require fast-forward/clock', $guide, true), 'Guide shell example changed');
    $php = "<?php\n\nuse FastForward\\Documentation\\Example;\n\n\$example = new Example();\necho \$example->greet('Dash');";
    requireValid(in_array($php, $guide, true), 'Guide PHP example changed');
    $api = $codeSamples[$output . '/classes/FastForward-Documentation-Example.html'];
    requireValid(in_array("\$example = new Example();\necho \$example->greet('Dash');", $api, true), 'API PHP example changed');
    printf("PASS: %d generated pages, nested reading anchors, theme icons, unchanged code examples and byte-identical assets\n", count($pages));
}

try {
    requireValid($argc === 2, 'Usage: php tests/verify-output.php /path/to/ff-template-preview');
    $output = realpath($argv[1]);
    requireValid($output !== false && is_dir($output), 'Generated output directory not found');
    verify($output);
} catch (Throwable $error) {
    fwrite(STDERR, $error->getMessage() . PHP_EOL);
    exit(1);
}
