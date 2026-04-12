#!/bin/bash
set -e -x

if [[ -z "${1:-}" ]]; then
    echo "Error: scenario not provided." >&2
    exit 1
fi

scenario=$1
runSmoke=${2:-true}
runAverage=${3:-true}
runStress=${4:-true}
runSpike=${5:-true}
htmlPrefix=$6

echo "Executing load test for scenario: $scenario"
echo "Options - Smoke: $runSmoke, Average: $runAverage, Stress: $runStress, Spike: $runSpike"
ENV_VARS=""
if [[ -n "${API_HOST:-}" ]]; then
  ENV_VARS="${ENV_VARS} -e API_HOST=${API_HOST}"
fi

if [[ -n "${API_PORT:-}" ]]; then
  ENV_VARS="${ENV_VARS} -e API_PORT=${API_PORT}"
fi

K6="docker run -v ./tests/Load:/loadTests --net=host --rm ${ENV_VARS} \
    --user $(id -u):$(id -g) \
    k6 run --summary-trend-stats='avg,min,med,max,p(95),p(99)' \
    --out 'dashboard=port=-1&period=1s&export=/loadTests/results/${htmlPrefix}${scenario}.html'"

eval "$K6" "/loadTests/scripts/${scenario}.js" -e run_smoke="${runSmoke}" -e run_average="${runAverage}" -e run_stress="${runStress}" -e run_spike="${runSpike}"
