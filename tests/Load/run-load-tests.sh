#!/bin/bash
set -e -x

echo "Running load tests..."
echo "Current directory: $(pwd)"
echo "----------------------------------------"
echo "Listing files:"
ls -l
echo "----------------------------------------"

LOAD_TEST_SCENARIOS=$(./tests/Load/get-load-test-scenarios.sh)
echo "Scenarios: $LOAD_TEST_SCENARIOS"

for scenario in $LOAD_TEST_SCENARIOS; do
  echo "$(date '+%Y-%m-%d %H:%M:%S') - Running scenario: $scenario"
  ./tests/Load/execute-load-test.sh "$scenario" true true true true all-
done
