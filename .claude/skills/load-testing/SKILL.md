---
name: load-testing
description: Create or update K6-based load tests in php-service-template.
---

# Load Testing

## Use This Skill When

- adding a scenario under `tests/Load/scripts/`
- changing load-test orchestration scripts
- debugging smoke, average, stress, or spike runs

## Commands

```bash
make smoke-load-tests
make average-load-tests
make stress-load-tests
make spike-load-tests
make load-tests
make execute-load-tests-script scenario=<name>
./tests/Load/get-load-test-scenarios.sh
```

## Rules

- Put K6 scenarios in `tests/Load/scripts/`.
- Keep scenario naming and config aligned with the existing shell wrappers.
- Prefer deterministic setup and teardown.
- Avoid hardcoded credentials or environment-specific values in committed test files.

## Verification Path

1. Start with `make smoke-load-tests`.
2. Run the single changed scenario if applicable.
3. Escalate to broader load commands only if needed.

## Related Files

- `tests/Load/`
- `docker-compose.load_test.override.yml`
- `tests/Load/config.json.dist`
