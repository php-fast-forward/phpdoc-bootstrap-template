<?php

declare(strict_types=1);

// Generate real guide and API documentation from either the checkout or a release archive.
$root = dirname(__DIR__);
$template = realpath($argv[1] ?? $root);
if ($template === false || !is_file($template . '/template.xml')) {
    throw new RuntimeException('A phpDocumentor template directory is required.');
}
$fixture = __DIR__ . '/fixture';
$temporary = sys_get_temp_dir() . '/ff-template-' . bin2hex(random_bytes(8));
if (!mkdir($temporary, 0700, true)) {
    throw new RuntimeException('Cannot create isolated fixture output.');
}
$config = new DOMDocument();
if (!$config->load($fixture . '/phpdoc.xml', LIBXML_NONET)) {
    throw new RuntimeException('Cannot load fixture configuration.');
}
$xpath = new DOMXPath($config);
$xpath->query('/phpdocumentor/paths/output')->item(0)->textContent = $temporary . '/output';
$xpath->query('/phpdocumentor/paths/cache')->item(0)->textContent = $temporary . '/cache';
$xpath->query('/phpdocumentor/template')->item(0)->setAttribute('name', $template);
foreach ($xpath->query('//source') as $source) {
    $source->setAttribute('dsn', $fixture);
}
if ($config->save($temporary . '/phpdoc.xml') === false) {
    throw new RuntimeException('Cannot save fixture configuration.');
}
foreach ([
    [PHP_BINARY, $root . '/vendor/bin/phpdoc', '--config', $temporary . '/phpdoc.xml'],
    [PHP_BINARY, __DIR__ . '/verify-output.php', $temporary . '/output'],
] as $command) {
    $process = proc_open($command, [STDIN, STDOUT, STDERR], $pipes, $fixture);
    if (!is_resource($process)) {
        throw new RuntimeException('Cannot start fixture validation.');
    }
    $result = proc_close($process);
    if ($result !== 0) {
        exit($result === -1 ? 1 : $result);
    }
}
