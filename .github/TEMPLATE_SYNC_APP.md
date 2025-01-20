# Template synchronization with GitHub App

Alternatively, you can configure a GitHub App to handle workflow permissions. This method offers a more integrated and secure approach compared to using a Personal Access Token (PAT).

For a detailed guide on how to set up a GitHub App and configure the necessary permissions, refer to the **[Autorelease action documentation](https://github.com/VilnaCRM-Org/php-service-template/blob/main/.github/AUTORELEASE.md)**.

## Overview

By configuring a GitHub App, you can automate repository synchronization while ensuring secure handling of repository permissions without manual token management.

### Steps Overview

1. **GitHub App Configuration**:

   - Create and configure the GitHub App with the required permissions (`Administration`, `Contents`, `Issues`, `Metadata`, and `Pull Requests`).

2. **Repository Secrets**:

   - Configure secrets for the private key and App ID.

3. **Branch Protection Rules**:
   - Set branch protection rules to allow force pushing by the GitHub App.

### GitHub Action Configuration

Below is an example of a GitHub action using the GitHub App for repository synchronization:

```yaml
name: Template Sync

on:
  schedule:
    - cron: '0 9 * * MON'
  workflow_dispatch:

jobs:
  repo-sync:
    runs-on: ubuntu-latest

    steps:
      - name: Generate token to read from source repo
        id: generate_token
        uses: tibdex/github-app-token@v2
        with:
          app_id: ${{ secrets.<GITHUB_APP_ID> }}
          private_key: ${{ secrets.<GITHUB_APP_PRIVATE_KEY> }}

      - name: Checkout
        uses: actions/checkout@v4
        with:
          token: ${{ steps.generate_token.outputs.token }}

      - name: actions-template-sync
        uses: AndreasAugustin/actions-template-sync@v2
        with:
          github_token: ${{ steps.generate_token.outputs.token }}
          source_repo_path: <owner/repo>
          upstream_branch: <target_branch> # defaults to main
          pr_labels: <label1>,<label2>[,...] # optional, no default
```
