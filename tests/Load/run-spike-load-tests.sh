#!/bin/bash
set -e

LOAD_TEST_SCENARIOS=$(./tests/Load/get-load-test-scenarios.sh)

for scenario in $LOAD_TEST_SCENARIOS; do
  ./tests/Load/execute-load-test.sh "$scenario" false false false true spike-
done