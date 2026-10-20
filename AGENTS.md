# Template maintenance

This repository owns a phpDocumentor Twig/Bootstrap template, not a PHP service
library. Preserve the Composer type `phpdocumentor-template` and existing public
template path. Follow `CONTRIBUTING.md` for change fragments and `DESIGN.md` for
visual identity. Merge, release and deployment require maintainer authorization.

## Bundled consumer skill

Read [the consumer skill](resources/skills/fast-forward-phpdoc-bootstrap-template/SKILL.md)
when changing consumer configuration, integration examples, guides or the skill.
Keep its version contract, references and checked examples aligned with public
template behavior. Its canonical distributable source is `resources/skills`;
do not add a second copy or host aliases. Package procedures belong in `SKILL.md`.

## Validation

Run `composer validate --strict`, `php tests/generate-fixture.php` and
`php tests/verify-consumer-skill.php` after installing development dependencies.
Check the archive too: `.gitattributes` excludes `/docs/`, so consumer skill
references and examples must remain inside their package. The CI workflow owns
the PHP matrix and archive rendering checks. Keep unrelated worktree changes.

## Child DOX Index

No child instruction contracts. The consumer package owns its procedure through
its linked `SKILL.md`; ordinary template and test folders share this root contract.
