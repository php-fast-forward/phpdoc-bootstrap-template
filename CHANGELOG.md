# Changelog

All notable changes to this project are documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/),
and this project follows [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [2.2.3] - 2026-10-29

### Fixed

- Resolve implemented interface links through phpDocumentor's native renderer so
  external interfaces without generated API pages remain visible without broken
  local links, and documented interfaces retain a single valid link.

  ([#18](https://github.com/php-fast-forward/phpdoc-bootstrap-template/pull/18))

## [2.2.2] - 2026-10-25

### Changed

- Synchronize the bundled local skill automatically and trust Fast Forward Composer
  skill donors through `fast-forward/*`.
  Resolve Changelog contributor skills from stable `0.4.x` releases without a
  redundant skill allowlist.

  ([#16](https://github.com/php-fast-forward/phpdoc-bootstrap-template/pull/16))

## [2.2.1] - 2026-10-21

### Fixed

- Preserves shared graph-page assets and initializes zoom controls after loading their dependency. Cancels pending zoom animation before resetting the diagram. ([#14](https://github.com/php-fast-forward/phpdoc-bootstrap-template/pull/14))
- Remove tracked Finder metadata and ignore .DS_Store files throughout the repository. ([#10](https://github.com/php-fast-forward/phpdoc-bootstrap-template/pull/10))
- Scopes member tag and attribute IDs and replaces existing fragments in section permalinks. ([#14](https://github.com/php-fast-forward/phpdoc-bootstrap-template/pull/14))
- Restores search results and active state when reopening an unchanged query. ([#14](https://github.com/php-fast-forward/phpdoc-bootstrap-template/pull/14))

## [2.2.0] - 2026-10-20

### Added

- Bundle a portable consumer skill with checked phpDocumentor examples, DevTools reports guidance and optional llm/skills discovery metadata. ([#8](https://github.com/php-fast-forward/phpdoc-bootstrap-template/pull/8))

## [2.1.1] - 2026-10-20

### Changed

- Adopt Fast Forward Changelog automation and its project skill for validated contribution notes and reviewed version pull requests. ([#6](https://github.com/php-fast-forward/phpdoc-bootstrap-template/pull/6))
- Restore the Changelog skill from its GitHub source during Composer installation instead of committing a generated copy and separate installation receipt. ([#6](https://github.com/php-fast-forward/phpdoc-bootstrap-template/pull/6))

## [2.1.0] - 2026-10-09

### Added

- Fast Forward documentation identity, with the approved fox signature and Dash reading companion.
- Light and navy reading themes with a compact accessible theme control and saved preference.
- Code windows with language labels, decorative window dots and an accessible copy button.
- Responsive guide outlines, improved navigation, search labels, focus states and print styles.
- PHP 8.3, 8.4 and 8.5 checks that generate real guide/API fixtures from both checkout and release archive.

### Changed

- Apply the shared design system's typography, colors and reading surfaces while preserving Bootstrap and phpDocumentor integration.

## [2.0.0] - 2026-04-19

## What's Changed
* Use guide index as homepage root by @coisa in https://github.com/php-fast-forward/phpdoc-bootstrap-template/pull/1

## New Contributors
* @coisa made their first contribution in https://github.com/php-fast-forward/phpdoc-bootstrap-template/pull/1

**Full Changelog**: https://github.com/php-fast-forward/phpdoc-bootstrap-template/compare/v1.0.2...v2.0.0

## [1.0.2] - 2026-04-05

**Full Changelog**: https://github.com/php-fast-forward/phpdoc-bootstrap-template/compare/v1.0.1...v1.0.2

## [1.0.1] - 2026-04-05

**Full Changelog**: https://github.com/php-fast-forward/phpdoc-bootstrap-template/compare/v1.0.0...v1.0.1

## [1.0.0] - 2026-04-01

**Full Changelog**: https://github.com/php-fast-forward/phpdoc-bootstrap-template/commits/v1.0.0

[2.2.3]: https://github.com/php-fast-forward/phpdoc-bootstrap-template/compare/v2.2.2...v2.2.3
[2.2.2]: https://github.com/php-fast-forward/phpdoc-bootstrap-template/compare/v2.2.1...v2.2.2
[2.2.1]: https://github.com/php-fast-forward/phpdoc-bootstrap-template/compare/v2.2.0...v2.2.1
[2.2.0]: https://github.com/php-fast-forward/phpdoc-bootstrap-template/compare/v2.1.1...v2.2.0
[2.1.1]: https://github.com/php-fast-forward/phpdoc-bootstrap-template/compare/v2.1.0...v2.1.1
[2.1.0]: https://github.com/php-fast-forward/phpdoc-bootstrap-template/compare/v2.0.0...v2.1.0
[2.0.0]: https://github.com/php-fast-forward/phpdoc-bootstrap-template/compare/v1.0.2...v2.0.0
[1.0.2]: https://github.com/php-fast-forward/phpdoc-bootstrap-template/compare/v1.0.1...v1.0.2
[1.0.1]: https://github.com/php-fast-forward/phpdoc-bootstrap-template/compare/v1.0.0...v1.0.1
[1.0.0]: https://github.com/php-fast-forward/phpdoc-bootstrap-template/releases/tag/v1.0.0
