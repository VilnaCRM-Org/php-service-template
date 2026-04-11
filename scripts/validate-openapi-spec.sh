#!/usr/bin/env bash
set -euo pipefail

REPO_ROOT="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
OPENAPI_DIR="$REPO_ROOT/.github/openapi-spec"
RULESET_PATH="$REPO_ROOT/.spectral.yaml"

if [[ ! -f "$OPENAPI_DIR/spec.yaml" ]]; then
  echo "Error: $OPENAPI_DIR/spec.yaml not found. Generate the OpenAPI spec before linting." >&2
  exit 1
fi

if [[ ! -f "$RULESET_PATH" ]]; then
  echo "Error: Spectral ruleset $RULESET_PATH not found." >&2
  exit 1
fi

docker run --rm \
  --user "$(id -u):$(id -g)" \
  -v "$OPENAPI_DIR:/workspace/openapi" \
  -v "$RULESET_PATH:/workspace/.spectral.yaml" \
  php-service-template-spectral \
  lint /workspace/openapi/spec.yaml \
  --ruleset /workspace/.spectral.yaml \
  --fail-severity=hint
