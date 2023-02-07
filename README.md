[![SWUbanner](https://raw.githubusercontent.com/vshymanskyy/StandWithUkraine/main/banner2-direct.svg)](https://supportukrainenow.org/)

# Microservice template for modern PHP applications

![Latest Stable Version](https://poser.pugx.org/VilnaCRM-Org/php-service-template/v/stable.svg)
[![Test status](https://github.com/VilnaCRM-Org/php-service-template/workflows/Tests/badge.svg)](https://github.com/VilnaCRM-Org/php-service-template/actions)
[![codecov.io](https://codecov.io/gh/VilnaCRM-Org/php-service-template/branch/main/graph/badge.svg?token=iORZpwmYmM)](https://codecov.io/gh/VilnaCRM-Org/php-service-template)

## Possibilities
- Modern PHP stack for services: [API Platform 3](https://api-platform.com/), PHP 8, [Symfony 6](https://symfony.com/)
- [Hexagonal Architecture, DDD & CQRS in PHP](https://github.com/CodelyTV/php-ddd-example)
- Built-in docker environment and convenient cli
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

## Installation & using
Add the following line to the file /etc/hosts:
> 127.0.0.1 service.local

Execute bash script to run project's containers
> ./make up -d

Go inside the php fpm container

> docker exec -it docker_crm-php-fpm_1 bash

Install all project dependencies

> composer install

Go to browser and open the link below

> http://service.local

That's it. You should now be ready to use PHP service template!

## Documentation
Start reading at the [GitHub wiki](https://github.com/VilnaCRM-Org/php-service-template/wiki). If you're having trouble, head for [the troubleshooting guide](https://github.com/VilnaCRM-Org/php-service-template/wiki/Troubleshooting) as it's frequently updated.

You can generate complete API-level documentation by running `phpdoc` in the top-level folder, and documentation will appear in the `docs` folder, though you'll need to have [PHPDocumentor](http://www.phpdoc.org) installed.

If the documentation doesn't cover what you need, search the [many questions on Stack Overflow](http://stackoverflow.com/questions/tagged/vilnacrm), and before you ask a question, [read the troubleshooting guide](https://github.com/VilnaCRM-Org/php-service-template/wiki/Troubleshooting).

## Tests
[Tests](https://github.com/VilnaCRM-Org/php-service-template/tree/main/tests/) use PHPUnit 9 and [Behat](https://github.com/Behat/Behat).

[![Test status](https://github.com/VilnaCRM-Org/php-service-template/workflows/Tests/badge.svg)](https://github.com/VilnaCRM-Org/php-service-template/actions)

If this isn't passing, is there something you can do to help?

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
