# Contributing

Add one unique `.changelog/*.md` fragment for each observable change. With
PHP 8.5+ and CPX, inspect `help add`, then create and validate the note:

```sh
cpx --skip-local fast-forward/changelog add "Describe the observable change." --category=fixed --no-interaction
cpx --skip-local fast-forward/changelog check --no-interaction
```

After committing, validate the contribution with `check --since=origin/main`.
Read the generated `.agents/skills/fast-forward-changelog/SKILL.md`
for the full procedure. Preserve published history and pending notes; do not add
an `Unreleased` section to `CHANGELOG.md`.

The GitHub workflow checks contributions, maintains PR feedback and prepares a
version PR. Review its exact changes before merging: that approved merge enables
automatic tag and GitHub Release publication. Installing the workflow publishes
nothing.

Run `composer install` to fetch the project skill into
`.agents/skills/fast-forward-changelog`. The committed `skills.json` selects its
GitHub source through `llm/skills`; generated `.agents` files stay out of Git.
This does not install Changelog's runtime dependencies into the library.
Inspect the copy with `composer skills:show` and refresh compatible versions with
`composer skills:update --from=github`. Keep the skill under this manager's
ownership; do not run the legacy Changelog skill installer on it.
