#!/usr/bin/env bash
set -euo pipefail

SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
PROJECT_ROOT="$(cd "$SCRIPT_DIR/.." && pwd)"

LOCKED_CONFIG_FILES=(
  "phpinsights.php"
  "psalm.xml"
  "deptrac.yaml"
  "infection.json5"
  ".php-cs-fixer.dist.php"
)

REQUIRED_DIRS=(
  "src"
  "src/Shared"
  "src/Shared/Application"
  "src/Shared/Domain"
  "src/Shared/Infrastructure"
  "config"
  "config/packages"
  "tests"
  "tests/Unit"
  "tests/Integration"
  "tests/Behat"
  ".github"
  ".github/openapi-spec"
  ".github/graphql-spec"
)

echo "Configuration Validation"
echo "========================"

errors=0

for dir in "${REQUIRED_DIRS[@]}"; do
  if [[ ! -d "$PROJECT_ROOT/$dir" ]]; then
    echo "[FAIL] Missing required directory: $dir" >&2
    errors=$((errors + 1))
  fi
done

modified_files=()
if git -C "$PROJECT_ROOT" rev-parse --is-inside-work-tree >/dev/null 2>&1; then
  if git -C "$PROJECT_ROOT" rev-parse --verify origin/main >/dev/null 2>&1; then
    merge_base="$(git -C "$PROJECT_ROOT" merge-base origin/main HEAD 2>/dev/null || true)"
    if [[ -n "$merge_base" ]]; then
      while IFS= read -r line; do
        [[ -n "$line" ]] && modified_files+=("$line")
      done < <(git -C "$PROJECT_ROOT" diff --name-only "$merge_base" HEAD 2>/dev/null || true)
    fi
  fi

  while IFS= read -r line; do
    [[ -n "$line" ]] && modified_files+=("$line")
  done < <(git -C "$PROJECT_ROOT" diff --name-only HEAD 2>/dev/null || true)

  while IFS= read -r line; do
    [[ -n "$line" ]] && modified_files+=("$line")
  done < <(git -C "$PROJECT_ROOT" diff --cached --name-only 2>/dev/null || true)

  while IFS= read -r line; do
    [[ -n "$line" ]] && modified_files+=("$line")
  done < <(git -C "$PROJECT_ROOT" diff --name-only origin/HEAD HEAD 2>/dev/null || true)

  while IFS= read -r line; do
    [[ -n "$line" ]] && modified_files+=("$line")
  done < <(git -C "$PROJECT_ROOT" diff --name-only HEAD^..HEAD 2>/dev/null || true)
fi

if [[ "${#modified_files[@]}" -gt 0 ]]; then
  mapfile -t modified_files < <(printf '%s\n' "${modified_files[@]}" | sort -u)
fi

for locked_file in "${LOCKED_CONFIG_FILES[@]}"; do
  for modified_file in "${modified_files[@]:-}"; do
    if [[ "$modified_file" == "$locked_file" ]]; then
      echo "Modification of locked configuration file is not allowed: $locked_file" >&2
      errors=$((errors + 1))
    fi
  done
done

if [[ "$errors" -gt 0 ]]; then
  echo "[FAIL] Configuration validation failed" >&2
  exit 1
fi

echo "[OK] Configuration validation passed"
