<?php

declare(strict_types=1);

// Exercise the distributable example without changing the consumer's project.
$root = dirname(__DIR__);
$template = realpath($argv[1] ?? $root);
if ($template === false || !is_file($template . '/template.xml')) {
    throw new RuntimeException('A phpDocumentor template directory is required.');
}
$example = $template . '/resources/skills/fast-forward-phpdoc-bootstrap-template/examples';
$temporary = sys_get_temp_dir() . '/ff-consumer-' . bin2hex(random_bytes(8));
if (!mkdir($temporary, 0700, true)) {
    throw new RuntimeException('Cannot create isolated consumer output.');
}
$config = new DOMDocument();
if (!$config->load($example . '/phpdoc.xml', LIBXML_NONET)) {
    throw new RuntimeException('Cannot load consumer configuration.');
}
$xpath = new DOMXPath($config);
$xpath->query('/phpdocumentor/paths/output')->item(0)->textContent = $temporary . '/output';
$xpath->query('/phpdocumentor/paths/cache')->item(0)->textContent = $temporary . '/cache';
$xpath->query('/phpdocumentor/template')->item(0)->setAttribute('name', $template);
foreach ($xpath->query('//source') as $source) {
    $source->setAttribute('dsn', $example);
}
if ($config->save($temporary . '/phpdoc.xml') === false) {
    throw new RuntimeException('Cannot save consumer configuration.');
}
foreach ([
    [PHP_BINARY, $root . '/vendor/bin/phpdoc', '--config', $temporary . '/phpdoc.xml'],
    [PHP_BINARY, $example . '/verify.php', $temporary . '/output'],
] as $command) {
    $process = proc_open($command, [STDIN, STDOUT, STDERR], $pipes, $example);
    if (!is_resource($process)) {
        throw new RuntimeException('Cannot start consumer validation.');
    }
    $result = proc_close($process);
    if ($result !== 0) {
        exit($result === -1 ? 1 : $result);
    }
}
printf("Consumer output: %s/output\n", $temporary);
