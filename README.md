[![SWUbanner](https://raw.githubusercontent.com/vshymanskyy/StandWithUkraine/main/banner2-direct.svg)](https://supportukrainenow.org/)

# Microservice template for modern PHP applications

[![CodeScene Code Health](https://img.shields.io/badge/CodeScene%20%7C%20Hotspot%20Code%20Health-9.7-brightgreen)](https://codescene.io/projects/39797)
[![CodeScene System Mastery](https://img.shields.io/badge/CodeScene%20%7C%20Average%20Code%20Health-9.8-brightgreen)](https://codescene.io/projects/39797)
[![codecov](https://codecov.io/gh/VilnaCRM-Org/php-service-template/branch/main/graph/badge.svg?token=J3SGCHIFD5)](https://codecov.io/gh/VilnaCRM-Org/php-service-template)
![PHPInsights code](https://img.shields.io/badge/PHPInsights%20%7C%20Code%20-100.0%25-success.svg)
![PHPInsights style](https://img.shields.io/badge/PHPInsights%20%7C%20Style%20-100.0%25-success.svg)
![PHPInsights complexity](https://img.shields.io/badge/PHPInsights%20%7C%20Complexity%20-100.0%25-success.svg)
![PHPInsights architecture](https://img.shields.io/badge/PHPInsights%20%7C%20Architecture%20-100.0%25-success.svg)
[![Maintainability](https://api.codeclimate.com/v1/badges/fc1ca51fd0faca36ab82/maintainability)](https://codeclimate.com/github/VilnaCRM-Org/php-service-template/maintainability)

## Possibilities

- Modern PHP stack for services: [API Platform 3](https://api-platform.com/), PHP 8, [Symfony 7](https://symfony.com/)

- [Hexagonal Architecture, DDD & CQRS in PHP](https://github.com/CodelyTV/php-ddd-example)

- Built-in docker environment and convenient `make` cli command

- A lot of CI checks to ensure the highest code quality that can be ([Psalm](https://psalm.dev/), [PHPInsights](https://phpinsights.com/), Security checks, Code style fixer)

- Configured testing tools: [PHPUnit](https://phpunit.de/), [Behat](https://docs.behat.org/)

- Much more!

## Why you might need it

Many PHP developers need to create new projects from scratch and spend a lot of time.

We decided to simplify this exhausting process and create a public template for modern PHP applications. This template is used for all our microservices in VilnaCRM.

## License

This software is distributed under the [Creative Commons Zero v1.0 Universal](https://creativecommons.org/publicdomain/zero/1.0/deed) license. Please read [LICENSE](https://github.com/VilnaCRM-Org/php-service-template/blob/main/LICENSE) for information on the software availability and distribution.

### Minimal installation

You can clone this repository locally or use Github functionality "Use this template"

Install the latest [docker](https://docs.docker.com/engine/install/) and [docker compose](https://docs.docker.com/compose/install/)

Use `make` command to set up project and automatically install all needed dependencies

> make start

Go to browser and open the link below

> https://localhost/api/docs

That's it. You should now be ready to use PHP service template!

## Using

You can use `make` command to easily control and work with project locally.

Execute `make` or `make help` to see the full list of project commands.

The list of the `make` possibilities:

```
aws-load-tests               Execute load tests on AWS
aws-load-tests-cleanup       Clean up AWS resources
bats                         Bats is a TAP-compliant testing framework for Bash
behat                        A php framework for autotesting business expectations
build                        Builds the images (PHP, caddy)
cache-clear                  Clears and warms up the application cache for a given environment and debug mode
cache-warmup                 Warmup the Symfony cache
changelog-generate           Generate changelog from a project's commit messages
check-requirements           Checks requirements for running Symfony and gives useful recommendations to optimize PHP for Symfony.
check-security               Checks security issues in project dependencies. Without arguments, it looks for a "composer.lock" file in the current directory. Pass it explicitly to check a specific "composer.lock" file.
commands                     List all Symfony commands
composer-validate            The validate command validates a given composer.json and composer.lock
coverage                     Create the code coverage report with PHPUnit
doctrine-migrations-generate Generates a blank migration class
doctrine-migrations-migrate  Executes a migration to a specified version or the latest available version
down                         Stop the docker hub
install                      Install vendors according to the current composer.lock file
update                       update vendors according to the current composer.json file
load-fixtures                Build the DB, control the schema validity, load fixtures and check the migration status
logs                         Show all logs
new-logs                     Show live logs
phpcsfixer                   A tool to automatically fix PHP Coding Standards issues
phpinsights                  Instant PHP quality checks and static analysis tool
phpunit                      The PHP unit testing framework
psalm                        A static analysis tool for finding errors in PHP applications
psalm-security               Psalm security analysis
purge                        Purge cache and logs
sh                           Log to the docker container
start                        Start docker
stop                         Stop docker and the Symfony binary server
up                           Start the docker hub (PHP, caddy)
```

## Documentation

Start reading at the [GitHub wiki](https://github.com/VilnaCRM-Org/php-service-template/wiki). If you're having trouble, head for [the troubleshooting guide](https://github.com/VilnaCRM-Org/php-service-template/wiki/Troubleshooting) as it's frequently updated.

You can generate complete API-level documentation by running `phpdoc` in the top-level folder, and documentation will appear in the `docs` folder, though you'll need to have [PHPDocumentor](http://www.phpdoc.org) installed.

If the documentation doesn't cover what you need, search the [many questions on Stack Overflow](http://stackoverflow.com/questions/tagged/vilnacrm), and before you ask a question, [read the troubleshooting guide](https://github.com/VilnaCRM-Org/php-service-template/wiki/Troubleshooting).

## Tests

[Tests](https://github.com/VilnaCRM-Org/php-service-template/tree/main/tests/) use PHPUnit 9 and [Behat](https://github.com/Behat/Behat).

[Test status](https://github.com/VilnaCRM-Org/php-service-template/actions)

If this isn't passing, is there something you can do to help?

## Running Load Tests in AWS

This template supports running load tests on AWS using k6, a modern load testing tool, to evaluate the performance of your application under various conditions. You can automate this process using a custom bash script that provisions an EC2 instance, attaches an IAM role, creates an S3 bucket for storing the results, and executes the k6 load tests.

### Steps for Running AWS Load Tests

#### 1. **Configure AWS CLI**:

Before you can interact with AWS, you'll need to [configure the AWS CLI](https://docs.aws.amazon.com/cli/v1/userguide/cli-chap-configure.html) with your credentials.
Run the following command and provide your AWS Access Key and Secret Access Key. Ensure that your AWS credentials and region are properly set to avoid any permission or region-based issues.

#### 2. **Run Load Tests**:

The `make aws-load-tests` runs the script that provisions an EC2 instance, attaches an IAM role, creates an S3 bucket for storing the results, and executes the load tests.

#### 3. **Configure CLI Options**:

To configure the AWS load testing, pass options through the CLI command to define the AWS environment settings, as needed for your project:

- `-r REGION`: Specifies the AWS region where the EC2 instance will be launched (e.g., `us-east-1`)
- `-a AMI_ID`: Defines the Amazon Machine Image (AMI) ID to use for the EC2 instance (e.g., `ami-0e86e20dae9224db8`)
- `-t INSTANCE_TYPE`: Sets the EC2 instance type (e.g., `t2.micro`)
- `-i INSTANCE_TAG`: Provides a tag to identify the EC2 instance (e.g., `LoadTestInstance`)
- `-o ROLE_NAME`: Specifies the IAM role name for the EC2 instance with write access to S3 (e.g., `EC2S3WriteAccessRole`)
- `-b BRANCH_NAME`: Sets the branch name for the project (e.g., `main`)
- `-s SECURITY_GROUP_NAME`: Defines the name of the security group to be used for the EC2 instance (e.g., `LoadTestSecurityGroup`)

#### 4. **Executing Load Tests**:

Once the EC2 instance is up, the predefined load tests are executed, simulating real-world conditions and workloads on your application.

#### 5. **Saving Results to S3**:

The results of the load tests are automatically uploaded to an S3 bucket for review and analysis.

#### 6. **Scaling and Flexibility**:

This approach allows you to scale the infrastructure to suit different performance testing needs, providing insights into how your service performs in a cloud-based, production-like environment.

### Cleanup AWS Infrastructure

After the load tests have been completed, it's important to clean up the AWS resources.
The `make aws-load-tests-cleanup` command automates the process of tearing down the EC2 instance, security groups, and other related AWS resources.

**Note:** This project utilizes AWS free tier services (EC2 micro instances, free security groups, free images, and volumes up to 30 GB), which minimizes cost concerns during AWS operations. However, it's still important to clean up resources to avoid any potential charges beyond the free tier limits.

## Repository Synchronization

This template is automatically synchronized with other repositories in our ecosystem. Whenever changes are made to the template, those changes are propagated to dependent projects, ensuring they stay up to date with the latest improvements and best practices.

We use this synchronization feature, for example, in the [user-service](https://github.com/VilnaCRM-Org/user-service) repository.

The synchronization is powered by the [actions-template-sync](https://github.com/AndreasAugustin/actions-template-sync) GitHub Action, which automates the process of propagating updates from this template to other projects.

### Handling Workflow Permissions Error

When setting up the repository synchronization, you may encounter permission-related issues. Below are two methods to resolve common workflow permissions errors: using a Personal Access Token (PAT) or using a GitHub App.

#### Option 1: Using a Personal Access Token (PAT)

Details on how to configure and use a PAT for repository synchronization can be found in the [TEMPLATE_SYNC_PAT.md](.github/TEMPLATE_SYNC_PAT.md) file inside the `.github` directory.

#### Option 2: Using a GitHub App

For projects that prefer GitHub App authentication, please refer to the [TEMPLATE_SYNC_APP.md](.github/TEMPLATE_SYNC_APP.md) file in the `.github` directory for setup instructions and examples.

## Security

Please disclose any vulnerabilities found responsibly – report security issues to the maintainers privately.

See [SECURITY](https://github.com/VilnaCRM-Org/php-service-template/tree/main/SECURITY.md) and [Security advisories on GitHub](https://github.com/VilnaCRM-Org/php-service-template/security).

## Contributing

Please submit bug reports, suggestions, and pull requests to the [GitHub issue tracker](https://github.com/VilnaCRM-Org/php-service-template/issues).

We're particularly interested in fixing edge cases, expanding test coverage, and updating translations.

If you found a mistake in the docs, or want to add something, go ahead and amend the wiki – anyone can edit it.

## Sponsorship

Development time and resources for this repository are provided by [VilnaCRM](https://vilnacrm.com/), the free and opensource CRM system.

Donations are very welcome, whether in beer 🍺, T-shirts 👕, or cold, hard cash 💰. Sponsorship through GitHub is a simple and convenient way to say "thank you" to maintainers and contributors – just click the "Sponsor" button [on the project page](https://github.com/VilnaCRM-Org/php-service-template). If your company uses this template, consider taking part in the VilnaCRM's enterprise support program.

## Changelog

See [changelog](CHANGELOG.md).
