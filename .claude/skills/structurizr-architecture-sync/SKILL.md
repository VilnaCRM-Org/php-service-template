---
name: structurizr-architecture-sync
description: Keep workspace.dsl aligned with significant architectural changes in php-service-template.
---

# Structurizr Architecture Sync

## Update `workspace.dsl` When You Add Or Change

- a major bounded context or module
- a new processor, controller, or command handler that changes the visible flow
- a new external dependency such as a queue, cache, or database integration
- a new repository or infrastructure boundary that matters to the architecture story

## Usually Skip `workspace.dsl` Updates For

- small helpers
- trivial refactors
- DTO-only changes
- unit-test-only changes

## Checklist

1. Add or adjust the component in `workspace.dsl`.
2. Keep layer naming aligned with Application, Domain, and Infrastructure concepts.
3. Update relationships when data flow changed.
4. Commit the architecture update with the code change, not later.

## Verification

- `workspace.dsl` still parses cleanly in your usual Structurizr flow
- the described components match the implementation
- README or contributor docs are updated if the architectural story materially changed
