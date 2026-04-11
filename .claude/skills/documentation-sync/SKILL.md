---
name: documentation-sync
description: Keep template-facing documentation and generated artifacts aligned with code changes.
---

# Documentation Sync

## Documentation Surfaces In This Template

- `README.md`
- `CONTRIBUTING.md`
- `SECURITY.md`
- `AGENTS.md`
- `CLAUDE.md`
- `.github/openapi-spec/spec.yaml`
- `.github/graphql-spec/spec`
- `workspace.dsl`

## Update This Material When

- local commands change
- workflow or contributor expectations change
- API surfaces change
- architecture changes
- new agent-support files or conventions are added

## Typical Sync Patterns

### Makefile or workflow change

- update `README.md`
- update contributor guidance if review expectations changed

### API change

- regenerate OpenAPI and GraphQL snapshots
- update `README.md` if user-visible commands or examples changed

### Architecture change

- update `workspace.dsl`
- update `README.md` if the template structure guidance changed

## Minimum Verification

- links and file references point to real paths
- command names match the current `Makefile`
- generated artifacts were refreshed in the same PR as the behavior change
