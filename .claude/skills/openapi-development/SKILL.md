---
name: openapi-development
description: Maintain exported OpenAPI and GraphQL snapshots for php-service-template.
---

# OpenAPI Development

## Use This Skill When

- a REST resource changes
- request or response fields change
- GraphQL schema changes
- exported spec snapshots drift in CI

## Commands

```bash
make generate-openapi-spec
make generate-graphql-spec
```

## Expectations

- `.github/openapi-spec/spec.yaml` reflects the current REST surface.
- `.github/graphql-spec/spec` reflects the current GraphQL surface.
- The exported snapshots belong in the same PR as the code change that caused them.

## Implementation Notes

- Keep API Platform metadata outside Domain classes.
- Prefer DTO and processor patterns for writes.
- When adding a new endpoint, validate the resource config, serialization, and generated snapshot together.

## Verification

After export:

```bash
make generate-openapi-spec
make generate-graphql-spec
make unit-tests
make integration-tests
```

If the change is architectural or documentation-facing, follow with `documentation-sync`.
