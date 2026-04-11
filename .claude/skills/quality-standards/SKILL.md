---
name: quality-standards
description: Reference the current protected quality gates for php-service-template.
---

# Quality Standards

## Protected Gates

### PHPInsights

- quality: 100
- complexity: 95
- architecture: 100
- style: 100

### Architecture

- Deptrac violations: 0

### Static Analysis

- Psalm errors: 0
- Psalm security findings should be treated as real issues unless proven otherwise

### Testing

- relevant PHPUnit, integration, Behat, and mutation checks should pass for the change

## Primary Commands

```bash
make phpcsfixer
make psalm
make psalm-security
make phpinsights
make deptrac
make unit-tests
make integration-tests
make behat
make infection
```

## Companion Skills

- complexity or maintainability issue -> `complexity-management`
- boundary violation -> `deptrac-fixer`
- failing tests -> `testing-workflow`
- generated spec drift -> `openapi-development`
