# Fast Forward documentation design

This template implements the approved documentation pattern from the [Fast Forward brand kit](https://github.com/php-fast-forward/.github/tree/654e4a463533f1d8b8223369b3b0bbc1a4a0badf). Twig and Bootstrap 5 remain the runtime foundation.

## Token mapping

| Role | Value | Template use |
| --- | --- | --- |
| Primary | `#6d28d9` | Active navigation, actions and light-surface links |
| Primary hover | `#5b21b6` | Interactive hover and pressed states |
| Navy | `#050b20` | Toolbar, navigation rail, code and navy reading surface |
| Cyan | `#22d3ee` | Dark-surface links, keyboard focus and Copy outline |
| Ink | `#142033` | Light-surface text |
| Neutral | `#f6f8ff` | Light reading surround and alternating table rows |
| Border | `#cbd5e1` | Light borders and dark secondary text |

Body and heading fonts use the system stack; code uses the system monospace stack. Heading sizes follow the kit's 3rem/2rem scale. Cards use 12px and 20px radii. Bootstrap variables and component-specific states are adapted in `css/base.css.twig`; no Tailwind processing is required.

## Behavior

Light is the default reading surface. The navy navigation rail stays consistent in both themes. A toolbar button progressively enables theme switching and stores the preference when local storage is available. Denied storage never blocks reading. Navigation uses native details on mobile, and the code Copy button appears only with a secure Clipboard API. Clipboard failures produce a visible status. Skip navigation, focus outlines, search labels, active-page semantics and reduced-motion/print styles are included.

Existing phpDocumentor destination-depth handling, Bootstrap collapse menus, Fuse search hooks and UML hooks remain intact. Required images are copied by FileIo transformations; consumers do not need to host the central kit.

## Artwork provenance

- `docs/_static/fast-forward-logo-dark.svg` copies the approved native outlined fox signature from `assets/brand/fast-forward-logo-dark.svg`.
- `docs/_static/dash-reading.png` copies the primary developer collection reading pose from `assets/mascot/dash-developer-reading.png`, SHA-256 `bb87dc5d6a8bbcde4510ca5f99e19a6a216a577b9c83aac2c5947454e2b1e982`.
- Source kit commit: `654e4a463533f1d8b8223369b3b0bbc1a4a0badf`.
- The maintainer requested this public template adaptation on 2026-10-05. This authorizes these assets for the template and its generated documentation. Historical reference-art rights remain unrecorded; no new independent artwork reuse license is asserted by the package's software license.

## Validation

Generate the fixture from `tests/fixture` with phpDocumentor 3:

```sh
phpdoc --config phpdoc.xml
```

The fixture includes root and nested guides, a PHP API class, admonitions, source examples and cross-document links. Generated HTML, CSS, JavaScript and copied images can then be inspected together. The test fixture is a development artifact and must be excluded from package distribution.

Run `python3 tests/verify-output.py /path/to/ff-template-preview` from the template checkout. It checks shared local assets and same-page reading anchors across every generated HTML page, including nested guides and API pages. Optional graph rendering belongs to the consumer's phpDocumentor configuration.

The implementation was generated with phpDocumentor 3.9.1 and visually compared with the kit's `profile/assets/docs-installation.png`: navy rail and purple active navigation, three-column desktop reading, system heading hierarchy, important callouts, and navy code panels with cyan Copy controls. Browser validation covered light/navy switching and persistence, guide outline anchors, code copy status, API search results, a 1440px desktop viewport and a 390px mobile viewport with no horizontal page overflow.

Deliberate adaptations: the generated site's project name appears beneath the framework signature; API/navigation content comes from phpDocumentor; guide outlines are progressively generated from rendered headings. The template keeps Bootstrap collapse and existing search/UML dependencies.
