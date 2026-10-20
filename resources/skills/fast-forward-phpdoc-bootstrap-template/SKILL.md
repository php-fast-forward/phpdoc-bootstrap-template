---
name: fast-forward-phpdoc-bootstrap-template
description: Configure and generate PHP API documentation and guides with the Fast Forward phpDocumentor Bootstrap template. Use for phpdoc.xml setup, guide homepages, template assets, output verification, or an existing Fast Forward DevTools reports integration.
license: MIT; see LICENSE
compatibility: Supports fast-forward/phpdoc-bootstrap-template ^2.1.1, PHP ^8.3 and phpDocumentor shim ^3.9. Requires Composer and phpDocumentor extensions; the verification example also uses DOM. Earlier template releases are outside this contract.
metadata:
  author: Fast Forward
  api-baseline: fast-forward/phpdoc-bootstrap-template ^2.1.1
---

# Generate Fast Forward documentation

Use this skill in a PHP project consuming `fast-forward/phpdoc-bootstrap-template
^2.1.1`. Inspect `composer.json`, `composer.lock`, existing documentation commands
and CI before editing. Run `composer show fast-forward/phpdoc-bootstrap-template`
and `composer show phpdocumentor/shim` to check installed versions. If they fall
outside this contract, inspect the matching version's documentation; do not
upgrade dependencies just to use this skill. The template has no PHP namespace,
container registration or application autoloader requirement: phpDocumentor
loads its `template.xml` and Twig files.

## Configure a guide homepage and API

Prefer an existing DevTools route if the project already uses it; load
[DevTools integration](references/dev-tools.md) for that case. Otherwise use the
direct route below. Preserve existing source exclusions and project conventions.

Prerequisites: PHP ^8.3, Composer, phpDocumentor's required extensions (including
DOM/XML, mbstring and intl), and trusted project sources. Graphviz `dot` is needed
for class diagrams. The template package alone does not install the generator.
With authority to install the project's development tooling, review/merge the
specific shim plugin approval and install:

```sh
composer config allow-plugins.phpdocumentor/shim true
composer require --dev 'fast-forward/phpdoc-bootstrap-template:^2.1.1' 'phpdocumentor/shim:^3.9'
```

From the project root, create `phpdoc.xml`:

```xml
<?xml version="1.0" encoding="UTF-8"?>
<phpdocumentor configVersion="3">
    <title>Example documentation</title>
    <paths>
        <output>build/docs</output>
        <cache>build/phpdoc-cache</cache>
    </paths>
    <version number="latest">
        <api>
            <include-source>true</include-source>
            <source dsn="."><path>src</path></source>
        </api>
        <guide format="rst">
            <source dsn="."><path>docs</path></source>
            <output>.</output>
        </guide>
    </version>
    <template name="vendor/fast-forward/phpdoc-bootstrap-template" />
</phpdocumentor>
```

Use the real PHP source directory in `<api>`. `include-source` exposes source
code in the generated public documentation; remove it if that is inappropriate.
Never scan private configuration, credentials, `vendor/` or test data as sources.
The example's single explicit `src` path bounds the scan.

Create `docs/index.rst`:

```rst
Example documentation
=====================

Welcome to the project documentation.

.. toctree::
   :maxdepth: 2

   guides/installation
```

Create `docs/guides/installation.rst`:

```rst
Installation
============

Install the project dependencies with Composer.

.. code-block:: shell

   composer install
```

Add a documented public PHP class in `src/` (one same-named class per file), or
use the project's existing classes. A complete minimal class and these exact
configuration/guide files are bundled under [examples](examples/phpdoc.xml).
No application bootstrap is executed to render this example; phpDocumentor
parses PHP sources. Use the existing Composer autoload configuration if the
application itself needs to execute those classes.

Generate from the project root:

```sh
vendor/bin/phpdoc --config phpdoc.xml
test -f build/docs/index.html
test -f build/docs/guides/installation.html
test -f build/docs/css/base.css
test -f build/docs/js/searchIndex.js
test -f build/docs/images/fast-forward-logo-dark.svg
test -f build/docs/images/dash-reading.png
```

`docs/index.rst` becomes `build/docs/index.html` because the guide output is `.`.
Keep this guide index: the template's transformations do not generate an API-only
root homepage. For an API-only project, provide a small landing guide or verify
and configure a separate landing-page strategy. Do not promise an automatic
fallback from the unused `index.html.twig` file.

## Check the generated site

Serve `build/docs` with the project's static preview tooling, or temporarily use
`php -S 127.0.0.1:8080 -t build/docs`. Check the homepage, nested guide, API class,
navigation, search, light/navy theme, narrow viewport and source links. Stop the
preview server after use. Publish the entire output tree so relative links,
search data and identity images survive nested hosting paths. Generation does
not authorize a Pages deployment.

For the bundled example, also run:

```sh
php /path/to/fast-forward-phpdoc-bootstrap-template/examples/verify.php build/docs
```

This verifier expects the bundled `Example` class and guide text. For a real
project adapt checks to its API names; a passing command with no generated HTML
is insufficient. It checks files/content, not browser behavior.

## Diagnose and customize

- Missing homepage: check the guide source, `docs/index.rst` and `<output>.</output>`.
- Missing API: inspect the `<api>` source path, PHP extensions/exclusions and
  phpDocumentor diagnostics; the template does not discover application sources.
- Missing template/assets: confirm the installed package and actual vendor path.
  For custom Composer `vendor-dir`, change both binary and template paths.
- Stale output: use a new disposable cache/output directory to compare; do not
  delete an existing public site or unrelated caches as a diagnostic step.
- Invalid XML or generator failure: retain diagnostics, correct inputs and check
  output again. For diagrams, inspect Graphviz availability separately.
- Markdown guides: the minimal route uses reStructuredText. Markdown requires a
  compatible phpDocumentor guide renderer; do not treat the template as a parser.
- Styling: inspect the installed Twig inheritance and `css/base.css.twig`. Make
  deliberate overrides in a project-owned complete template or maintained fork;
  pass its path as the template. Editing `vendor/` is overwritten by Composer.
  Copy runtime `data/` assets and `template.xml` transformations together. There
  is no promised configuration key for arbitrary Twig overrides.

For optional copying/synchronization of this skill, load
[installation and lifecycle](references/installation.md). Installing the template,
copying this skill and having an agent load it are separate steps.
