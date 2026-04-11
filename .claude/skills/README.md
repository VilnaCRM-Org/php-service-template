# AI Agent Skills For `php-service-template`

This directory contains the template-safe Claude skills baseline for this repository. The files are plain Markdown so they can be followed by Claude Code, Codex, Copilot, Cursor, or other AI coding assistants.

## Quick Start

1. Read [AI-AGENT-GUIDE.md](AI-AGENT-GUIDE.md).
2. Use [SKILL-DECISION-GUIDE.md](SKILL-DECISION-GUIDE.md) to choose a skill.
3. Open the selected `SKILL.md`.
4. Run the commands listed there with `make` first; if no matching target exists, use `docker compose exec php ...`.

## Available Skills

- `api-platform-crud` - Add REST resources with DTO, validation, and processor patterns
- `ci-workflow` - Run the current template verification stack
- `complexity-management` - Fix PHPInsights score regressions without lowering thresholds
- `deptrac-fixer` - Resolve architectural boundary violations
- `documentation-sync` - Keep README, specs, and architecture docs aligned with changes
- `load-testing` - Add or update K6-based load tests
- `openapi-development` - Maintain generated OpenAPI and GraphQL snapshots
- `quality-standards` - Reference protected quality expectations for this template
- `structurizr-architecture-sync` - Keep `workspace.dsl` aligned with major architecture changes
- `testing-workflow` - Run and debug unit, integration, Behat, Infection, and Bats flows

## Scope

These skills are intentionally adapted to the template itself. They avoid `user-service`-specific MongoDB, OAuth, and repo-internal automation assumptions so they can be copied forward into services created from this template.
