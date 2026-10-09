# Fast Forward documentation design

This template implements the approved documentation pattern from the [Fast Forward brand kit](https://github.com/php-fast-forward/.github). Twig and Bootstrap 5 remain the runtime foundation.

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

Light is the default reading surface. The navy navigation rail stays consistent in both themes. A compact sun/moon toolbar button progressively enables theme switching, labels the next action for assistive technology and stores the preference when local storage is available. Denied storage never blocks reading. Navigation uses native details on mobile. Code blocks progressively gain a window header with three decorative dots and a centered language label; an icon Copy control appears only with a secure Clipboard API. Copied feedback uses a tooltip and live region. Clipboard failures leave a visible instruction to select the code. The header stays separate from horizontally scrolling code, and copying preserves the exact example text. Skip navigation, focus outlines, search labels, active-page semantics and reduced-motion/print styles are included.

Existing phpDocumentor destination-depth handling, Bootstrap collapse menus, Fuse search hooks and UML hooks remain intact. Required images are copied by FileIo transformations; consumers do not need to host the central kit.

## Assets

- `data/fast-forward-logo-dark.svg` copies the approved native outlined fox signature from `assets/brand/fast-forward-logo-dark.svg`.
- `data/dash-reading.png` copies the developer reading pose from `assets/mascot/dash-developer-reading.png`.
- Source repository: [php-fast-forward/.github](https://github.com/php-fast-forward/.github).

Runtime images live in `data/` so excluding consumer documentation from a Composer archive still preserves the generated site's identity assets.

## Validation

Install the development tool with `composer install --no-scripts`, then run `php tests/generate-fixture.php`. Composer allows only the official `phpdocumentor/shim` plugin, which installs the signed phpDocumentor PHAR; no runtime dependency is added to template consumers. The CI matrix renders the fixture with PHP 8.3, 8.4 and 8.5 from both the checkout and a Git archive, and actionlint validates the workflow. The PHAR's bundled dependencies are outside Composer's dependency-audit coverage; use this build tool only with trusted project sources.

Generate the fixture from `tests/fixture` with phpDocumentor 3:

```sh
phpdoc --config phpdoc.xml
```

The fixture includes root and nested guides, a PHP API class, admonitions, source examples and cross-document links. Generated HTML, CSS, JavaScript and copied images can then be inspected together.

Run `php tests/verify-output.php /path/to/ff-template-preview` from the template checkout. It uses PHP's DOM extension to check shared local assets, same-page reading anchors and the accessible icon theme control across every generated HTML page, including nested guides and API pages. It also checks unchanged guide/API code examples and that copied identity images match the template files byte for byte. Optional graph rendering belongs to the consumer's phpDocumentor configuration.

The implementation was generated with phpDocumentor 3.9.1 and visually compared with the kit's `profile/assets/docs-installation.png`: navy rail and purple active navigation, three-column desktop reading, system heading hierarchy, important callouts, and navy code panels with cyan Copy controls. Browser validation covered light/navy switching and persistence, guide outline anchors, code copy status, API search results, a 1440px desktop viewport and a 390px mobile viewport with no horizontal page overflow.

Deliberate adaptations: the generated site's project name appears beneath the framework signature; API/navigation content comes from phpDocumentor; guide outlines are progressively generated from rendered headings. The template keeps Bootstrap collapse and existing search/UML dependencies.
