#!/usr/bin/env bash
set -euo pipefail

REPO_ROOT="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
BASE_REF="${1:-origin/main}"
OPENAPI_DIR="$REPO_ROOT/.github/openapi-spec"
HEAD_SPEC="$OPENAPI_DIR/spec.yaml"
TMP_DIR="$(mktemp -d)"
BASE_SPEC="$TMP_DIR/openapi-base-spec.yaml"
OPENAPI_DIFF_IMAGE="${OPENAPI_DIFF_IMAGE:-openapitools/openapi-diff:2.1.2}"

trap 'rm -rf "$TMP_DIR"' EXIT

if [[ ! -f "$HEAD_SPEC" ]]; then
  echo "Error: $HEAD_SPEC not found. Generate the OpenAPI spec before running the diff." >&2
  exit 1
fi

if ! git -C "$REPO_ROOT" show "$BASE_REF:.github/openapi-spec/spec.yaml" >"$BASE_SPEC" 2>/dev/null; then
  echo "Error: Unable to read .github/openapi-spec/spec.yaml from $BASE_REF." >&2
  exit 1
fi

docker run --rm \
  -v "$HEAD_SPEC:/workspace/head.yaml" \
  -v "$BASE_SPEC:/workspace/base.yaml" \
  "$OPENAPI_DIFF_IMAGE" \
  /workspace/base.yaml \
  /workspace/head.yaml
