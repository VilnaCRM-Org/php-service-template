# AI Agent Guide To The Skills System

This repository uses a lightweight skills system for repeatable engineering workflows.

## How To Use It

1. Classify the task.
2. Read `SKILL-DECISION-GUIDE.md`.
3. Open the matching `SKILL.md`.
4. Follow the verification steps in that skill.
5. Only then summarize the work as complete.

## General Rules

- Use `make` targets before raw commands.
- If a required target does not exist, use `docker compose exec php ...`.
- Do not edit configuration thresholds just to satisfy CI.
- Regenerate specs when API surfaces change.
- Update `workspace.dsl` when architecture changes in a meaningful way.

## Suggested Flow

### Code change

1. Pick the implementation skill.
2. Apply the code change.
3. Run `ci-workflow`.
4. Run `documentation-sync` if the change affects docs, specs, or architecture.

### API change

1. Use `api-platform-crud` or `openapi-development`.
2. Export `.github/openapi-spec/spec.yaml`.
3. Export `.github/graphql-spec/spec`.
4. Re-run tests and architecture checks.

### Architecture change

1. Use `deptrac-fixer` or `structurizr-architecture-sync`.
2. Keep Domain code framework-free.
3. Update `workspace.dsl`.

## Current Skill Set

The available skills in this template are the ones listed in `.claude/skills/README.md`. If a task falls outside them, follow the closest skill and adapt pragmatically without inventing repository rules that contradict existing tooling.
