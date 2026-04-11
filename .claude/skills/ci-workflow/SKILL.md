---
name: ci-workflow
description: Run the current php-service-template verification stack and fix failures without lowering quality thresholds.
---

# CI Workflow

## Goal

Validate the repository using the commands that currently back GitHub Actions for this template.

## Full Verification Stack

Run the relevant subset for the change. For application code, default to the full stack:

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

## Rules

- Prefer `make` targets.
- If a command needs the PHP container, do not bypass Docker wrappers.
- Do not lower thresholds in `phpinsights.php`.
- Do not loosen Deptrac rules in `deptrac.yaml`.
- Do not weaken coverage or mutation settings just to make the job pass.

## Common Failure Routing

- `make phpcsfixer` or style drift: fix formatting, then rerun the stack.
- `make psalm` or `make psalm-security`: fix types or taint issues in code.
- `make phpinsights`: use `complexity-management`.
- `make deptrac`: use `deptrac-fixer`.
- `make unit-tests` / `make integration-tests` / `make behat` / `make infection`: use `testing-workflow`.
- Spec drift after API change: use `openapi-development`.

## Minimum Close-Out

Before marking a code change complete, confirm:

- relevant checks pass locally, or
- you explicitly state what could not be run and why, and
- the remaining validation is delegated to GitHub Actions.
