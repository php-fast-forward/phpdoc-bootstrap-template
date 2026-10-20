<?php

declare(strict_types=1);

// Run against the output of examples/phpdoc.xml, from any working directory.
if ($argc !== 2 || !is_dir($argv[1])) {
    fwrite(STDERR, "Usage: php verify.php /path/to/generated/docs\n");
    exit(1);
}

$output = rtrim($argv[1], '/');
foreach ([
    'index.html' => 'Welcome to the project documentation.',
    'guides/installation.html' => 'composer install',
    'classes/Example-Documentation-Example.html' => 'greet',
    'css/base.css' => '#6d28d9',
    'js/searchIndex.js' => 'Example',
    'js/template.js' => 'fast-forward-documentation-theme',
    'images/fast-forward-logo-dark.svg' => '<svg',
    'images/dash-reading.png' => "\x89PNG",
] as $path => $expected) {
    $file = $output . '/' . $path;
    $contents = is_file($file) ? file_get_contents($file) : false;
    if ($contents === false || !str_contains($contents, $expected)) {
        fwrite(STDERR, "Missing or invalid generated artifact: {$path}\n");
        exit(1);
    }
}
echo "PASS: consumer homepage, nested guide, API, search and theme assets\n";
