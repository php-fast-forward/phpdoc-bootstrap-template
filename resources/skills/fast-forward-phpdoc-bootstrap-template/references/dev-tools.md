# Existing Fast Forward DevTools integration

Load when the consumer already uses `fast-forward/dev-tools` or asks about its
reports workflow. This skill supports template ^2.1.1. Check the separate
DevTools surface with `dev-tools reports:docs --help`: its template constraint
`^2.0` alone does not guarantee this skill's minimum version. It also requires
phpDocumentor shim `^3.9`.

## Generate locally

Run from the consumer using its existing DevTools launcher:

```sh
dev-tools reports:docs --help
dev-tools reports:docs --source=docs --target=build/docs
test -f build/docs/index.html
```

Use `vendor/bin/dev-tools` for a project-local binary. Keep the existing
installation mode; the direct phpDocumentor route does not require DevTools.

The command defaults to guides in `docs`, resolves API directories from the
consumer's Composer autoload configuration and writes its own phpDocumentor XML
in its managed cache. It includes `<guide><output>.</output></guide>`, using
`vendor/fast-forward/phpdoc-bootstrap-template` by default and resolving the
preferred vendor location for its installation mode. `--template=/absolute/path`
selects an alternative. `--source` chooses guides, not the API directory.

A root `phpdoc.xml` does not override this generated configuration. Use supported
command options, or invoke phpDocumentor directly with that XML for custom
settings. Do not edit cached generated XML as permanent configuration.

An explicitly requested missing guide directory fails. With the default path,
DevTools may generate API-only output or skip successfully when neither API nor
guides are detected. A success/skip message does not establish a root homepage:
supply a guide index for this template and verify generated files. Use isolated
cache/output paths for diagnosis.

## Reports workflow

The reusable `php-fast-forward/dev-tools/.github/workflows/reports.yml` invokes
`dev-tools reports --target="${REPORTS_TARGET}"`, with `.dev-tools` as report root,
alongside coverage and metrics. The docs command selects this template, rather
than a separate template setting in YAML. The workflow also manages Pages, PR
previews and cleanup: it has deployment permissions and side effects.

For an already approved reusable-workflow integration, a minimal caller is:

```yaml
name: Reports
on:
  workflow_dispatch:
permissions:
  contents: write
  pull-requests: write
jobs:
  reports:
    uses: php-fast-forward/dev-tools/.github/workflows/reports.yml@35d27ee20066fd9e234d228bb866102c64c7ef1a
```

This pins the inspected source revision. Before adopting it, review its
full job permissions, PHP/Composer setup, Pages settings and preview policy.
Keep existing triggers; this example requires manual dispatch. Do not dispatch
or deploy merely to test the skill. The reusable workflow can check out helper
actions from `main`; pinning the caller does not necessarily freeze helpers.

For generation-only CI, install approved locked dev dependencies, run
`vendor/bin/phpdoc --config phpdoc.xml`, check files and retain artifacts under
project policy. Pages publication is a separate maintainer decision.

Inspected primary source entrypoints (recheck the installed version/selected ref):

- [DocsCommand](https://github.com/php-fast-forward/dev-tools/blob/35d27ee20066fd9e234d228bb866102c64c7ef1a/src/Console/Command/DocsCommand.php)
- [Generated XML](https://github.com/php-fast-forward/dev-tools/blob/35d27ee20066fd9e234d228bb866102c64c7ef1a/resources/phpdocumentor.xml)
- [Reports workflow](https://github.com/php-fast-forward/dev-tools/blob/35d27ee20066fd9e234d228bb866102c64c7ef1a/.github/workflows/reports.yml)
