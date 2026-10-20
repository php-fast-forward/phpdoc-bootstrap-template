# Contributing

Add one unique `.changelog/*.md` fragment for each observable change. With
PHP 8.5+ and CPX, inspect `help add`, then create and validate the note:

```sh
cpx --skip-local fast-forward/changelog:0.3.0 add "Describe the observable change." --category=fixed --no-interaction
cpx --skip-local fast-forward/changelog:0.3.0 check --no-interaction
```

After committing, validate the contribution with `check --since=origin/main`.
Read [.agents/skills/fast-forward-changelog/SKILL.md](.agents/skills/fast-forward-changelog/SKILL.md)
for the full procedure. Preserve published history and pending notes; do not add
an `Unreleased` section to `CHANGELOG.md`.

The GitHub workflow checks contributions, maintains PR feedback and prepares a
version PR. Review its exact changes before merging: that approved merge enables
automatic tag and GitHub Release publication. Installing the workflow publishes
nothing. To review a future skill update, use `skill:install --check --json`
with the deliberately selected release, followed by `--update` when appropriate.
