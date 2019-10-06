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

# Dependencies

- PHP 7.1 or higher build with Ctype, Intl, iconv, JSON, PCRE, Session, SimpleXML, and Tokenizer.
- Composer
- Symfony binary (for development)
- Nginx or Apache Web server (for production)
- A database management system supported by Doctrine ORM, preferably MySQL, or MariaDB.

## Optional Dependencies

- [RabbitMQ](https://en.wikipedia.org/wiki/RabbitMQ) server (for automatic salary re-calculation)

# Installing Dependencies

- [Install Composer](https://getcomposer.org/download/).
- [Install Symfony](https://symfony.com/download)
- [Install Node.Js](https://nodejs.org/en/download/) (for Symfony Encore, frontend).
- [Install Yarn](https://yarnpkg.com/lang/en/docs/install/) (for frontend).

## Enabling TLS in Development Environment

For secure (TLS) connections in development environment follow the steps below:

1. Install `certutil` (shipped with [NSS Tools](http://www.mozilla.org/projects/security/pki/nss/tools/))
- Apt (Debian-based systems): `libnss3-tools`
- Yum (RPM-based systems): `nss-tools`
- Portage: `dev-libs/nss [utils]`
2. Install a TLS certificate: `symfony server:ca:install`

# Configuring

## DSN

In the project root directory, create `.env.local` file and specify the DSN as follows:
```
DATABASE_URL=mysql://salaryman:n2Nv69WvaVGwV4DM@127.0.0.1:3306/salaryman
```

## RabbitMQ

RabbitMQ bundle is configured for the default server settings in `config/packages/old_sound_rabbit_mq.yaml`. So you don't need to change them, if you have the default RabbitMQ setup.

If you do not want to configure RabbitMQ, then the automatic salary calculation will be disabled, and the only way to update the salaries would be running the following command:
```
bin/console --no-ansi rabbitmq:consumer  -vv calc_salaries
```

## PHP version

Symfony might use a PHP version different from the one configured on your machine. For example, on my Gentoo machine I have  PHP 7.3 enabled for the CLI SAPI:
```
ruslan@osmanov-pc ~/projects/salaryman $ eselect php list cli
  [1]   php7.1
  [2]   php7.2
  [3]   php7.3 *
```

However, Symfony somehow managed to choose 7.1:
```
$ symfony local:php:list
┌─────────┬───────────┬────────────┬─────────┬─────────┬─────────┬─────────┐
│ Version │ Directory │  PHP CLI   │ PHP FPM │ PHP CGI │ Server  │ System? │
├─────────┼───────────┼────────────┼─────────┼─────────┼─────────┼─────────┤
│ 7.1.30  │ /usr      │ bin/php7.1 │         │         │ PHP CLI │ *       │
│ 7.2.19  │ /usr      │ bin/php7.2 │         │         │ PHP CLI │         │
│ 7.3.9   │ /usr      │ bin/php    │         │         │ PHP CLI │         │
│ 7.3.9   │ /usr      │ bin/php7.3 │         │         │ PHP CLI │         │
└─────────┴───────────┴────────────┴─────────┴─────────┴─────────┴─────────┘
```
(**7.1.30 was highlighted**)

For consistence, create `.php-version` file in the project root directory and put the desired PHP version number there, e.g.:
```
printf '7.3.9\n' > .php-version
```

## Notes

The following demonstrates a minimal database setup:

```
create database salaryman default character set utf8;
create user salaryman@localhost identified by 'n2Nv69WvaVGwV4DM';
grant all on salaryman.* to salaryman@localhost;
flush privileges;
```

# Building

Execute the following commands from the project root directory.

## Development Environment

```
# Set Node.js environment
export NODE_ENV=dev

#Install Composer packages
composer install

# Build frontend files
yarn encore dev

# Check if all Symfony requirements are satisfied
symfony check:requirements

# Apply database migrations
php bin/console doctrine:migrations:migrate
```

## Production Environment

This is a demo project, so nobody will run it on "production". But, for the sake of completeness, I'll also list the commands you'd run in production environment:

```
export NODE_ENV=prod
composer install --no-dev
yarn encore dev
yarn encore production
symfony check:requirements
php bin/console doctrine:migrations:migrate
```

# Running

## Web Server

In development environment, it is okay to run the [Symfony local Web server](https://symfony.com/doc/current/setup/symfony_server.html), if you don't want to configure Nginx or Apache.
However, in production environment, a full-fledged Web server (such as Nginx, or Apache) is a must.

```
symfony server:start
```

## Re-calculating Salaries in command line interface

From the project root directory, run:

```
bin/console app:calc-salaries -vvv
```

## Salary Calculator

Launch the RabbitMQ consumer for automatic salary re-calculation:
```
bin/console --no-ansi rabbitmq:consumer  -vv calc_salaries
```

# Testing

- Build the project in "development" mode (see "Installing" section above).
- Change to the project root, then run: `./bin/phpunit`.

# License

MIT

© 2019 Ruslan Osmanov <rrosmanov@gmail.com>
