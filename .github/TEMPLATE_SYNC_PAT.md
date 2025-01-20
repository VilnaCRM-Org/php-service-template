# Template synchronization with a Personal Access Token (PAT)

Currently, the `GITHUB_TOKEN` cannot be granted workflow permissions by default. You can grant the workflow permissions using a Personal Access Token (PAT) by following these steps:

1. [Create a PAT](https://docs.github.com/en/authentication/keeping-your-account-and-data-secure/managing-your-personal-access-tokens#creating-a-fine-grained-personal-access-token) with the following repository permissions:
   - `contents:write`
   - `workflows:write`
   - `metadata:read`

To make the options for repository permissions (such as contents:write, workflows:write, and metadata:read) appear, ensure that the access level is not set to read-only.

2. Copy the generated token and [create a new secret](https://docs.github.com/en/actions/security-for-github-actions/security-guides/using-secrets-in-github-actions#creating-secrets-for-a-repository) for your target repository.

3. Configure the checkout action to use the token in secrets, as shown below:

   ```yaml
   # File: .github/workflows/template-sync-app.yml

   on:
     # cronjob trigger
     schedule:
       - cron: '0 0 1 * *'
     # manual trigger
     workflow_dispatch:

   jobs:
     repo-sync:
       runs-on: ubuntu-latest
       # https://docs.github.com/en/actions/using-jobs/assigning-permissions-to-jobs
       permissions:
         contents: write
         pull-requests: write

       steps:
         # To use this repository's private action, you must check out the repository
         - name: Checkout
           uses: actions/checkout@v4
           with:
             # submodules: true
             token: ${{ secrets.<secret_name> }}

         - name: actions-template-sync
           uses: AndreasAugustin/actions-template-sync@v2
           with:
             github_token: ${{ secrets.GITHUB_TOKEN }}
             source_repo_path: <owner/repo>
             upstream_branch: <target_branch> # defaults to main
             pr_labels: <label1>,<label2>[,...] # optional, no default
   ```

4. If you encounter the error `pull request create failed: Actions is not permitted to create or approve pull requests (createPullRequest)`, follow these additional steps:

   - Go to your project’s **Settings** > **Actions** > **General**.
   - Under the **Workflow permissions** section, check the box for **Allow GitHub Actions to create and approve pull requests**.

Following these steps should resolve any permission issues with workflows, allowing smooth synchronization between repositories.
