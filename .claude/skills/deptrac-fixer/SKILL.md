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
- Doctrine metadata belongs in XML mapping files, not in Domain PHP classes.
- API Platform metadata belongs in YAML resource configuration, DTOs, processors, or Application code.
- Infrastructure may depend on Domain and Application. Domain must not depend on Symfony, Doctrine, or API Platform.

## Common Fix Patterns

### Domain imports Symfony validator

- Remove the framework import from the Domain class.
- Move validation rules into YAML config under `config/`.

### Domain imports Doctrine attributes

- Remove Doctrine attributes from the entity.
- Add or update XML mapping under `config/doctrine/`.

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
