# CLAUDE.md

This repository includes a template-safe Claude skills baseline under `.claude/skills/`.

## Start Here

1. Read `AGENTS.md`.
2. Read `.claude/skills/AI-AGENT-GUIDE.md`.
3. Use `.claude/skills/SKILL-DECISION-GUIDE.md` to choose the right skill.

## Project Snapshot

- Symfony 7 and API Platform 4
- PHP 8.2+ with a pinned Composer platform of PHP 8.3.12
- Doctrine ORM and Doctrine Migrations
- OpenAPI and GraphQL exported into `.github/`
- Load tests under `tests/Load/`
- Architecture captured in `workspace.dsl`

## Command Reference

Use the repository wrappers first:

```bash
make start
make install
make phpcsfixer
make psalm
make phpinsights
make deptrac
make setup-test-db
make unit-tests
make integration-tests
make behat
make infection
make generate-openapi-spec
make generate-graphql-spec
make load-tests
```

If a needed command is missing from `Makefile`, use `docker compose exec php ...` instead of host PHP commands.

## Current Agent Contract

- Do not lower quality gates to make checks pass.
- Keep Domain classes free of Symfony, Doctrine attributes, and API Platform attributes.
- Prefer YAML or XML configuration for framework concerns.
- Update docs and generated specs when behavior changes.
- Treat `.claude/skills/` as the primary execution guide for agent work in this template.
