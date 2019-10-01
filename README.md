Solution to a technical challenge. Created **only for demonstration purposes**, so there is no practical use in it.

# Description

The application is called "**Salaryman**" (for "**Salary man**ager"). Salaryman can calculate the salary of employees as follows:

- Country Tax for salaries is 20%
- If an employee older than 50 we want to add 7% to his salary
- If an employee has more than 2 kids we want to decrease his Tax by 2%
- If an employee wants to use a company car we need to deduct $500

Salaryman also features an expandable system of bonuses/deductions.

## Sample Use Cases

- Alice is 26 years old, she has 2 kids and her salary is $6000
- Bob is 52, he is using a company car and his salary is $4000
- Charlie is 36, he has 3 kids, company car and his salary is $5000

# Requirements

- PHP 7.1 or higher build with Ctype, iconv, JSON, PCRE, Session, SimpleXML, and Tokenizer.
- Composer
- Symfony binary (for development)
- Nginx or Apache Web server (for production)

It is recommended to enable the Intl extension (for PHP validators).

# Installing

1. [Install Composer](https://getcomposer.org/download/).
2. For *development*, [Install Symfony](https://symfony.com/download) and check if all Symfony requirements are satisfied by running the following command:
```
symfony check:requirements
```
3. Download the project, change to the project root directory.
4. Run `composer install`. On production, use `--no-dev` (release/production mode).

# Building

From the project root directory, run `composer install --no-dev`. (Don't use `--no-dev` option if you are going to run unit tests.)

# Running

For development, you can use the [Symfony local Web server](https://symfony.com/doc/current/setup/symfony_server.html), if you don't want to configure Nginx or Apache.

# Testing

1. Build the project in "development" mode (see "Installing" section above).
2. Change to the project root, then run: `./bin/phpunit`.

# License

MIT

© 2019 Ruslan Osmanov <rrosmanov@gmail.com>
