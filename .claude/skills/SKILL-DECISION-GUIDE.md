# Skill Decision Guide

Choose the primary skill based on the task you are solving.

## Decision Tree

```text
What are you trying to do?
|
|- Run or fix repository checks
|  `- ci-workflow
|
|- Fix failing tests or add tests
|  `- testing-workflow
|
|- Fix a layer or dependency violation
|  `- deptrac-fixer
|
|- Reduce PHPInsights complexity or maintainability issues
|  `- complexity-management
|
|- Add or change an API Platform resource
|  `- api-platform-crud
|
|- Regenerate or repair OpenAPI / GraphQL snapshots
|  `- openapi-development
|
|- Add or update K6 scenarios
|  `- load-testing
|
|- Update README, generated specs, or contributor docs
|  `- documentation-sync
|
|- Update C4 or repository architecture description
|  `- structurizr-architecture-sync
|
`- Need the current quality gates and command matrix
   `- quality-standards
```

## Combined Scenarios

- New endpoint: `api-platform-crud` + `testing-workflow` + `openapi-development` + `documentation-sync`
- Deptrac failure after refactor: `deptrac-fixer` + `ci-workflow`
- Complex handler or subscriber: `complexity-management` + `testing-workflow`
- New repository or entity with architecture updates: `api-platform-crud` + `deptrac-fixer` + `structurizr-architecture-sync`

## Non-Negotiables

- Fix root causes instead of muting tools.
- Use Docker-backed commands.
- Keep framework concerns out of Domain classes.
