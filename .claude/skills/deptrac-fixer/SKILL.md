---
name: deptrac-fixer
description: Fix architectural boundary violations without editing deptrac.yaml.
---

# Deptrac Fixer

## Goal

Resolve Deptrac violations by changing code placement and dependencies, not by weakening the rules.

## Command

```bash
make deptrac
```

## Core Rules For This Template

- Domain classes must stay framework-free.
- Symfony validation belongs in YAML configuration, DTOs, or Application validators.
- Doctrine-backed entities are limited to the repository mapping configured in `config/packages/doctrine.yaml` under `src/Shared/Domain/Entity`; keep ORM metadata consistent there instead of scattering persistence details across unrelated Domain PHP classes.
- API Platform metadata belongs in YAML resource configuration, DTOs, processors, or Application code.
- Infrastructure may depend on Domain and Application. Domain must not depend on Symfony, Doctrine, or API Platform.

## Common Fix Patterns

### Domain imports Symfony validator

- Remove the framework import from the Domain class.
- Move validation rules into YAML config under `config/`.

### Domain imports Doctrine attributes

- If the class is not meant to be a Doctrine entity, remove the Doctrine attributes from the Domain class.
- If the class is meant to be persisted, keep it inside the configured entity mapping area and align the Doctrine mapping strategy with `config/packages/doctrine.yaml` instead of introducing ad hoc persistence rules elsewhere in the Domain layer.

### Domain imports API Platform attributes

- Move the metadata into API Platform YAML configuration.

### Wrong layer placement

- Move handlers, processors, controllers, or subscribers out of Domain and into Application or Infrastructure.

## Verification

After the architectural fix:

```bash
make deptrac
make psalm
make unit-tests
```

If the change is large, finish with `ci-workflow`.
