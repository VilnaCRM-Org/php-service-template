---
name: complexity-management
description: Preserve PHPInsights quality standards for php-service-template without lowering thresholds.
---

# Complexity Management

## Protected Thresholds

From `phpinsights.php`:

- `min-quality`: 100
- `min-complexity`: 95
- `min-architecture`: 100
- `min-style`: 100

Do not lower them.

## Command

```bash
make phpinsights
```

## Refactoring Guidance

- Replace nested conditionals with guard clauses.
- Split long handlers, processors, or subscribers into smaller private methods.
- Move orchestration out of Domain entities and keep domain logic focused.
- Extract duplicated decision logic into dedicated services or value objects.
- Prefer small explicit branches over large catch-all methods.

## Typical Hotspots In This Template

- API processors
- event subscribers
- controllers
- console command handlers
- complex test setup helpers

## Verification

Run:

```bash
make phpinsights
make psalm
make unit-tests
```

If the change also moved code across layers, add `make deptrac`.
