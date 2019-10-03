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

- PHP 7.1 or higher build with Ctype, Intl, iconv, JSON, PCRE, Session, SimpleXML, and Tokenizer.
- Composer
- Symfony binary (for development)
- Nginx or Apache Web server (for production)

# Installing

1. [Install Composer](https://getcomposer.org/download/).
2. For *development*, [Install Symfony](https://symfony.com/download) and check if all Symfony requirements are satisfied by running the following command:
```
symfony check:requirements
```
3. Download the project, change to the project root directory.
4. Run `composer install`. On production, use `--no-dev` (release/production mode).
5. [Install Node.Js](https://nodejs.org/en/download/) (for Symfony Encore, frontend).
6. [Install Yarn package manager](https://yarnpkg.com/lang/en/docs/install/) (for frontend).
7. Run `yarn install`
8. Install yarn packages for SASS files:
```
yarn add sass-loader@^7.0.1 node-sass --dev
```

## Enabling TLS in Development Environment

For secure (TLS) connections in development environment follow the steps below:

1. Install `certutil` (shipped with http://www.mozilla.org/projects/security/pki/nss/tools/; `apt` package: `libnss3-tools`, 'yum' package: `nss-tools`).
2. Install a TLS certificate: `symfony server:ca:install`
3. Re-start the local Web server, if it is running.
4. Check if the application is accessible through HTTPS: `https://127.0.0.1:8000/`.

# Configuring

1. Change to thr project root directory.
2. Create `.env.local` file and specify the database connection DSN as follows:
```
DATABASE_URL=mysql://salaryman:n2Nv69WvaVGwV4DM@127.0.0.1:3306/salaryman
```

## Notes

The following example shows how to create a database and a user in MySQL console client.

```
mysql> create database salaryman default character set utf8;
Query OK, 1 row affected (0.001 sec)

mysql> create user salaryman@localhost identified by 'n2Nv69WvaVGwV4DM';
Query OK, 0 rows affected (0.013 sec)

mysql> grant all on salaryman.* to salaryman@localhost; 
Query OK, 0 rows affected (0.001 sec)

mysql> flush privileges;
Query OK, 0 rows affected (0.001 sec)
```

# Building

Change to the project root directory.

0. In production environment, run `export NODE_ENV=prod`.
1. Run `composer install --no-dev`. (Don't use `--no-dev` option if you are going to run unit tests.)
2. Build frontend files:
2.1. For development environment, `yarn encore dev`
2.2. For production environment, `yarn encore production`
3. Apply database migrations: `php bin/console doctrine:migrations:migrate`.

# Running

For development, you can use the [Symfony local Web server](https://symfony.com/doc/current/setup/symfony_server.html), if you don't want to configure Nginx or Apache.

# Testing

1. Build the project in "development" mode (see "Installing" section above).
2. Change to the project root, then run: `./bin/phpunit`.

# License

MIT

© 2019 Ruslan Osmanov <rrosmanov@gmail.com>
