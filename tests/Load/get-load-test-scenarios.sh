#!/bin/bash
# Find all scenario script files and output their base names without extensions, one per line
find ./tests/Load/scripts -name "*.js" -exec basename {} .js \;
