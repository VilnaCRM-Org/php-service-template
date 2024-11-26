# Autorelease action

## Overview

Auto-release workflows automate the process of creating software releases in response to specific triggers like merging a pull request or pushing to a certain branch. This automation helps streamline the development process, reduce human error, and ensure consistent release practices.

---

## Why You Might Need Auto-Release

Consistency: Automating the release process ensures that every release adheres to predefined standards and procedures, reducing the risk of human error and inconsistency in the release quality.

Efficiency: By automating the changelog generation and release process, teams can save time and focus on development and testing rather than on the operational details of creating a release.

Integration: Auto-release workflows can be integrated with other tools and workflows, such as continuous integration (CI) systems, to ensure that releases are made only when all tests pass, maintaining the quality of the code in the production.

Traceability: Automated releases include detailed logs and changelogs, providing a clear audit trail for changes, which is beneficial for debugging and understanding the project’s history.

Speed: Automation speeds up the process of releasing and deploying software, which is especially crucial in high-paced agile environments where multiple releases might occur in a single day.

---

## Updating Versions

The auto-release process uses [Conventional Commits](https://www.conventionalcommits.org/en/v1.0.0/) to determine semantic versioning updates automatically. The type of commit message defines whether the version will be updated as a **PATCH**, **MINOR**, or **MAJOR** release.

### Version Update Rules

1. **PATCH**: Incremented for bug fixes.

   - Example: `fix(#3): resolve null pointer exception`
   - Result: `1.0.0` → `1.0.1`

2. **MINOR**: Incremented for new features without breaking existing functionality.

   - Example: `feat(#3): add user profile page`
   - Result: `1.0.1` → `1.1.0`

3. **MAJOR**: Incremented for breaking changes or significant alterations to APIs.

   - Example:

     ```
     feat(#3): overhaul authentication system

     BREAKING CHANGE: authentication now requires OAuth2
     ```

   - Result: `1.1.0` → `2.0.0`

---

## Setting Up an Auto-Release Workflow

#### 1) The GitHub App configuration

##### Creating the GitHub App

1. Go to Settings > Developer Settings > GitHub Apps (Developer Settings is at the bottom of the Settings page).
2. Click on New GitHub App.
3. Configure the following:
   - Complete the necessary details for the application.
   - Uncheck the active webhook.
   - Set the following Repository Permissions:
     - Administration: Read and Write
     - Contents: Read and Write
     - Issues: Read and Write
     - Metadata: Read Only
     - Pull Requests: Read and Write
   - Check "Install Only on this account"

##### Installing the App

Follow [GitHub's guide](https://docs.github.com/en/apps/using-github-apps/installing-your-own-github-app) on installing your apps to repositories you own.

##### Generating Private Key

1. Go to the app's settings and generate a new private key.
2. Copy the private key to a safe place.
3. Copy the app ID (found in Settings > Application > configure your GitHub App > app settings).

You will need both the private key and app ID as repository secrets.

#### 2) The GitHub repository configuration

1. Go to Settings > Secrets and Variables > Actions.
2. Create two new secrets:

- `VILNACRM_APP_PRIVATE_KEY`: Add the private key you generated earlier.
- `VILNACRM_APP_ID`: Add the app ID you copied.

#### 3) Allow force push

To ensure the GitHub App can perform necessary actions:

1. Go to Settings > Branches.
2. In the branch protection rules, check the option to "Allow force pushes".
3. Specify that the only allowed actor is the GitHub app you installed.

Note: Force pushing allows overwriting the Git history. It's restricted to the GitHub App to maintain security while allowing necessary operations for the auto-release workflow.
