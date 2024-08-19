#!/bin/bash
set -e -x

if [ -z "$1" ]; then
    echo "Error: scenario not provided."
    exit 1
fi

scenario=$1
runSmoke=$2
runAverage=$3
runStress=$4
runSpike=$5
htmlPrefix=$6

echo "Executing load test for scenario: $scenario"
echo "Options - Smoke: $runSmoke, Average: $runAverage, Stress: $runStress, Spike: $runSpike"
K6="docker run -v ./tests/Load:/loadTests --net=host --rm \
    --user $(id -u) \
    k6 run --summary-trend-stats='avg,min,med,max,p(95),p(99)' \
    --out 'web-dashboard=period=1s&export=/loadTests/results/${htmlPrefix}${scenario}.html'"

eval "$K6" "/loadTests/scripts/${scenario}.js" -e run_smoke="${runSmoke}" -e run_average="${runAverage}" -e run_stress="${runStress}" -e run_spike="${runSpike}"
