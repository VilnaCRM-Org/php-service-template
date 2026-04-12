[![SWUbanner](https://raw.githubusercontent.com/vshymanskyy/StandWithUkraine/main/banner2-direct.svg)](https://supportukrainenow.org/)

# PHP Service Template

[![CodeScene Code Health](https://img.shields.io/badge/CodeScene%20%7C%20Hotspot%20Code%20Health-9.7-brightgreen)](https://codescene.io/projects/39797)
[![CodeScene System Mastery](https://img.shields.io/badge/CodeScene%20%7C%20Average%20Code%20Health-9.8-brightgreen)](https://codescene.io/projects/39797)
[![codecov](https://codecov.io/gh/VilnaCRM-Org/php-service-template/branch/main/graph/badge.svg?token=J3SGCHIFD5)](https://codecov.io/gh/VilnaCRM-Org/php-service-template)
![PHPInsights code](https://img.shields.io/badge/PHPInsights%20%7C%20Code%20-100.0%25-success.svg)
![PHPInsights style](https://img.shields.io/badge/PHPInsights%20%7C%20Style%20-100.0%25-success.svg)
![PHPInsights complexity](https://img.shields.io/badge/PHPInsights%20%7C%20Complexity%20-100.0%25-success.svg)
![PHPInsights architecture](https://img.shields.io/badge/PHPInsights%20%7C%20Architecture%20-100.0%25-success.svg)
[![Maintainability](https://api.codeclimate.com/v1/badges/fc1ca51fd0faca36ab82/maintainability)](https://codeclimate.com/github/VilnaCRM-Org/php-service-template/maintainability)

`php-service-template` is the VilnaCRM baseline for enterprise-grade PHP services. It combines Symfony 7, API Platform 4, FrankenPHP, PostgreSQL, contract generation, architecture guards, and AI-assistant guidance into one template that downstream services can inherit without rebuilding the same platform concerns.

## Why this template exists

New services usually waste time on the same setup work: runtime packaging, CI hardening, contract tooling, architecture boundaries, and internal contributor guidance. This template packages those decisions once and keeps them synchronized across VilnaCRM services.

It is built to give new repositories:

- A modern runtime based on PHP 8.3, Symfony 7, API Platform 4, FrankenPHP, PostgreSQL, Mercure, and Vulcain
- A DDD, CQRS, and hexagonal structure with `src/Shared`, subdomain isolation, and Deptrac-enforced boundaries
- Generated OpenAPI and GraphQL artifacts under `.github/` so compatibility checks become part of delivery
- A CI stack covering static analysis, mutation testing, load testing, API contract validation, and GitHub-native security checks
- A template-safe workflow for AI coding assistants that points tools at the real commands and quality gates of the repository

## Enterprise-grade baseline

This repository is intended for services that need operational discipline, not just scaffolding:

- `FrankenPHP` serves the application directly, reducing local and CI drift versus split reverse-proxy and PHP-FPM setups
- `Psalm`, `Psalm security`, `PHPMD`, `PHPInsights`, `Deptrac`, `Infection`, `PHPUnit`, `Behat`, `Bats`, K6, Spectral, OpenAPI Diff, and Schemathesis are part of the repository workflow
- `workspace.dsl` and Structurizr keep architecture visible and reviewable
- Contract artifacts are generated, versioned, and checked for backward compatibility
- The repo is designed to be synchronized into downstream services so improvements land across the platform consistently

## Quick start

Install the latest [Docker Engine](https://docs.docker.com/engine/install/) and [Docker Compose](https://docs.docker.com/compose/install/), then boot the local stack:

```bash
make start
```

The development override starts FrankenPHP, PostgreSQL, LocalStack, and Structurizr. Useful entry points:

- REST API docs: <https://localhost/api/docs>
- GraphQL endpoint: <https://localhost/api/graphql>
- HTTP test and load-test entrypoint: <http://localhost:8081>
- Structurizr Lite: <http://localhost:8080/workspace/diagrams>

Run `make help` to inspect the current command surface.

## AI skills workflow

This template ships repository-level instructions for AI assistants such as Codex, Claude Code, Copilot, Cursor, and similar tools.

### Read in this order

1. [`AGENTS.md`](AGENTS.md)
2. [`.claude/skills/AI-AGENT-GUIDE.md`](.claude/skills/AI-AGENT-GUIDE.md)
3. [`.claude/skills/SKILL-DECISION-GUIDE.md`](.claude/skills/SKILL-DECISION-GUIDE.md)
4. The matching `SKILL.md` under [`.claude/skills/`](.claude/skills/)

### Available repository skills

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

### How to use them well

The best prompt pattern is explicit and repository-aware:

```text
Read AGENTS.md and the matching file from .claude/skills before changing code.
Use make targets first, keep Domain code framework-free, and regenerate OpenAPI or GraphQL specs when the API changes.
```

These files are plain Markdown by design. They are meant to be portable across AI tools while still describing this repository's actual verification flow.

## Local development

Prefer the repository wrappers over raw host commands. Common entry points:

```bash
make start
make install
make setup-test-db
make composer-validate
make psalm
make psalm-security
make phpinsights
make deptrac
make validate-openapi-spec
make openapi-diff
make schemathesis-validate
make load-tests
```

If you need a shell in the running application container:

```bash
make sh
```

## CI and verification model

The repository is supposed to fail fast when code, contracts, or architecture drift. The baseline includes:

- Composer validation and Symfony requirement checks
- Dependency security scanning, CodeQL, and GitHub Advanced Security analysis
- PHP CS Fixer, Rector, PHPMD, Psalm, Psalm taint analysis, PHPInsights, and Deptrac
- PHPUnit, Behat, Bats, Infection, and K6 load tests
- OpenAPI generation, Spectral validation, OpenAPI diff, GraphQL diff, and Schemathesis validation

For a local high-signal pass:

```bash
make ci
```

For contract-focused verification:

```bash
make generate-openapi-spec
make validate-openapi-spec
make openapi-diff
make schemathesis-validate
```

## Repository synchronization

This template is synchronized into downstream repositories across the VilnaCRM ecosystem. Runtime, CI, documentation, and AI-assistant improvements can therefore be propagated instead of reimplemented service by service.

Two sync approaches are documented here:

- [`.github/TEMPLATE_SYNC_PAT.md`](.github/TEMPLATE_SYNC_PAT.md)
- [`.github/TEMPLATE_SYNC_APP.md`](.github/TEMPLATE_SYNC_APP.md)

The `user-service` repository is one of the consumers kept aligned with this template.

## Load testing in AWS

The repository includes an AWS-oriented K6 workflow for cloud-based performance runs. Use:

```bash
make aws-load-tests
make aws-load-tests-cleanup
```

These scripts provision temporary infrastructure, execute the configured scenarios, and upload results to S3. Clean up after every run to avoid unnecessary charges.

## Documentation

- Wiki: <https://github.com/VilnaCRM-Org/php-service-template/wiki>
- Troubleshooting: <https://github.com/VilnaCRM-Org/php-service-template/wiki/Troubleshooting>
- Security policy: [SECURITY.md](SECURITY.md)
- Changelog: [CHANGELOG.md](CHANGELOG.md)

## License

This software is distributed under the [Creative Commons Zero v1.0 Universal](https://creativecommons.org/publicdomain/zero/1.0/deed) license. See [LICENSE](LICENSE).
