# Repository Guidelines

`php-service-template` is a Symfony and API Platform microservice template for VilnaCRM services. It targets PHP 8.2+, uses Doctrine ORM migrations, ships OpenAPI and GraphQL snapshots under `.github/`, and keeps architecture aligned with Hexagonal, DDD, and CQRS patterns.

This file is documentation-only guidance for coding assistants. It does not add runtime AI agent features to the template.

## Mandatory Workflow For AI Agents

Before making non-trivial changes:

1. Read `.claude/skills/AI-AGENT-GUIDE.md`.
2. Read `.claude/skills/SKILL-DECISION-GUIDE.md`.
3. Open the matching skill file under `.claude/skills/<skill>/SKILL.md`.
4. Follow the workflow in that skill before claiming the task is complete.

## Working Rules

- Use `make` targets first. If a target does not exist, use `docker compose exec php ...`.
- Do not run PHP tooling directly on the host when the repository already wraps it in Docker.
- Fix code to satisfy checks. Do not weaken `phpinsights.php`, `deptrac.yaml`, PHPUnit coverage setup, or Infection settings to make failures disappear.
- Keep Domain code framework-free. Validation, Doctrine mapping, and API Platform metadata belong outside Domain classes.
- When API behavior changes, regenerate `.github/openapi-spec/spec.yaml` and `.github/graphql-spec/spec`.
- When architecture changes, update `workspace.dsl`.

## Verification Baseline

For application changes, run the relevant parts of this stack:

```bash
make composer-validate
make check-requirements
make check-security
make phpcsfixer
make psalm
make psalm-security
make phpinsights
make deptrac
make setup-test-db
make unit-tests
make integration-tests
make behat
make infection
make generate-openapi-spec
make generate-graphql-spec
```

For documentation-only changes, run the smallest relevant subset and rely on GitHub Actions for the full matrix.

## Skill Inventory

This template currently ships these Claude skills:

- `api-platform-crud`
- `ci-workflow`
- `complexity-management`
- `deptrac-fixer`
- `documentation-sync`
- `load-testing`
- `openapi-development`
- `quality-standards`
- `structurizr-architecture-sync`
- `testing-workflow`

Start with `.claude/skills/README.md` for the index.
