---
name: testing-workflow
description: Run and debug the test suites used by php-service-template.
---

# Testing Workflow

## Test Surfaces

- `make bats` - Bash and Makefile behavior
- `make unit-tests` - Unit suite
- `make integration-tests` - Integration suite
- `make behat` - BDD and end-to-end scenarios
- `make tests-with-coverage` - PHPUnit with Clover output
- `make infection` - Mutation testing

## Setup

For anything that touches database-backed behavior:

```bash
make setup-test-db
```

## Practical Order

### Small change

```bash
make unit-tests
```

### Persistence or request-flow change

```bash
make setup-test-db
make unit-tests
make integration-tests
make behat
```

### Risky refactor

```bash
make setup-test-db
make unit-tests
make integration-tests
make behat
make infection
```

## Debugging Notes

- Re-run the smallest failing suite first.
- If only integration or Behat fails, confirm the database was recreated with `make setup-test-db`.
- When mutation testing fails, improve tests rather than relaxing Infection.
- If Makefile behavior is changed, run `make bats`.

## Done Criteria

- The changed behavior is covered by at least one relevant suite.
- The suite that failed has been rerun successfully.
- Any unrun suites are explicitly called out in the final summary.
