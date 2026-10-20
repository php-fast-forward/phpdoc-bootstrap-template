# Install the consumer skill

Supports `fast-forward/phpdoc-bootstrap-template ^2.1.1`; earlier versions are
outside this contract. Inspect the installed version and source directory:
`vendor/fast-forward/phpdoc-bootstrap-template/resources/skills/fast-forward-phpdoc-bootstrap-template`.
If absent, inspect that distribution or obtain the skill from a reviewed
immutable revision. Do not upgrade application dependencies just for instructions.
Composer-shipped files, a discovery copy and agent activation are separate steps.
Prefer project scope for team review; global use is an explicit personal choice.

## Optional llm/skills ^1.15 project route

Requires Composer, compatible PHP, the installed donor and the consumer's approval
to execute the development plugin. Merge this `skills.json` before first
installation/sync, preserving existing settings and intentional aliases:

```json
{
  "target": ".agents/skills",
  "aliases": [],
  "discovery": false,
  "auto-sync": true,
  "vendor-sources": false,
  "dependencies": {
    "composer": {
      "trusted": ["fast-forward/phpdoc-bootstrap-template"],
      "trusted-replace": true
    }
  }
}
```

With the project's specific plugin trust decision:

```sh
composer config allow-plugins.llm/skills true
composer require --dev 'llm/skills:^1.15'
composer skills:show
```

Preserve other approvals. The donor's `suggest` neither installs nor approves the
plugin. Commit intended configuration/lockfile under project policy. Approved
install/update synchronizes the donor into
`.agents/skills/fast-forward-phpdoc-bootstrap-template`; no cleanup hook is needed.
For explicit sync, set `auto-sync:false` before plugin installation:

```sh
composer skills:show
composer skills:update fast-forward/phpdoc-bootstrap-template --dry-run
composer skills:update fast-forward/phpdoc-bootstrap-template
```

A named package intentionally selects/trusts it for that run. With Composer
2.10.3 and llm/skills 1.15.0, `--no-scripts` alone does not suppress automatic
sync. Use `auto-sync:false`, or `--no-plugins` to prevent plugin execution.

Copies are donor-managed: same-path files overwrite local edits; extra local
files and files removed upstream can remain. Removing donor or plugin leaves
copies behind. Inspect diffs and record source versions on updates. Keep local
instructions under a separate skill name.

Preview cleanup only: `composer skills:update --clean --dry-run`. Unscoped clean
can delete handwritten skills. Scoped clean reinstalls selected donors; it does
not identify an already removed donor. Inventory/archive the exact stale package
outside discovery before authorized cleanup. Never add a blanket clean hook.

## Manual project copy or explicit global copy

Copy the complete package, refusing existing directories and dangling symlinks:

```sh
skill_source="vendor/fast-forward/phpdoc-bootstrap-template/resources/skills/fast-forward-phpdoc-bootstrap-template"
skill_target=".agents/skills/fast-forward-phpdoc-bootstrap-template"
test -f "$skill_source/SKILL.md" &&
test ! -e "$skill_target" && test ! -L "$skill_target" &&
mkdir -p "$(dirname "$skill_target")" &&
cp -R "$skill_source" "$skill_target"
```

For explicit global Codex scope choose
`$HOME/.agents/skills/fast-forward-phpdoc-bootstrap-template` as `skill_target`.
For Claude Code choose `.claude/skills/fast-forward-phpdoc-bootstrap-template`
or its home counterpart. Verify host discovery roots and avoid duplicate copies.
Do not symlink into replaceable `vendor/` files.

For update/removal, archive only the selected package outside discovery:

```sh
skill_backup="$HOME/.agent-skill-backups/fast-forward-phpdoc-bootstrap-template-$(date +%Y%m%d%H%M%S)-$$"
test -d "$skill_target" && test ! -L "$skill_target" &&
test ! -e "$skill_backup" && test ! -L "$skill_backup" &&
mkdir -p "$(dirname "$skill_backup")" &&
mv "$skill_target" "$skill_backup"
```

For update review the new donor and repeat the guarded copy. To roll back,
archive any replacement first, restore the complete saved directory to its
original destination and refresh the session. For removal leave it outside
discovery. Managed copies may return on sync until donor/trust selection changes.
Never put backups under a discovery root.

## Optional pinned Skills CLI

Requires Node.js 22.20.0+, npm and Git for repository sources. Review the tool
before execution. The local donor avoids a moving remote source:

```sh
npx --yes skills@1.7.2 add ./vendor/fast-forward/phpdoc-bootstrap-template/resources/skills/fast-forward-phpdoc-bootstrap-template --skill fast-forward-phpdoc-bootstrap-template --agent codex --copy --yes
npx --yes skills@1.7.2 list --agent codex
```

For a repository source set `SKILL_REF` to a reviewed full commit SHA and use
`https://github.com/php-fast-forward/phpdoc-bootstrap-template/tree/$SKILL_REF/resources/skills/fast-forward-phpdoc-bootstrap-template`
as the source argument. Choose the actual host (`claude-code` for Claude Code).
Add `--global` to both add/list commands only for global scope. `--copy` avoids
links into Composer-managed files. Back up edits before replacing with a reviewed
source; commit intended copies/CLI lockfiles. Remove only the selected name/scope:

```sh
npx --yes skills@1.7.2 remove fast-forward-phpdoc-bootstrap-template --agent codex --yes
# Explicit global alternative:
npx --yes skills@1.7.2 remove fast-forward-phpdoc-bootstrap-template --agent codex --global --yes
```

A globally installed Composer plugin is not global host skill installation.
After any route inspect files, refresh the agent session, confirm discovery and
request a bounded documentation task. Copy success does not prove activation.
