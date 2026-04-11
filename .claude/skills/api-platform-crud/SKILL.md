---
name: api-platform-crud
description: Add or extend API Platform resources in php-service-template using DDD and CQRS-friendly patterns.
---

# API Platform CRUD

## Goal

Implement REST resources without leaking framework concerns into Domain classes.

## Pattern

1. Create or update the Domain entity.
2. Keep persistence metadata in XML mapping under `config/doctrine/`.
3. Add API Platform resource configuration under `config/api_platform/` or `config/routes/`.
4. Use DTOs, processors, and handlers for write flows when the behavior is more than trivial CRUD.
5. Regenerate exported specs.

## Rules

- No Doctrine or API Platform attributes in Domain classes.
- Keep business rules in Domain, orchestration in Application, persistence in Infrastructure.
- Use validation outside Domain objects.
- Make sure serialization and resource configuration align with the generated OpenAPI surface.

## Verification

```bash
make generate-openapi-spec
make generate-graphql-spec
make setup-test-db
make unit-tests
make integration-tests
make behat
make deptrac
```

Use `openapi-development` and `documentation-sync` as follow-up skills when needed.
