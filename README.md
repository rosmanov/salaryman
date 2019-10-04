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
- A database management system supported by Doctrine ORM, preferably MySQL, or MariaDB.

# Installing Dependencies

- [Install Composer](https://getcomposer.org/download/).
- [Install Symfony](https://symfony.com/download)
- [Install Node.Js](https://nodejs.org/en/download/) (for Symfony Encore, frontend).
- [Install Yarn](https://yarnpkg.com/lang/en/docs/install/) (for frontend).
- Check if all Symfony requirements are satisfied by running the following command:
```
symfony check:requirements
```

## Enabling TLS in Development Environment

For secure (TLS) connections in development environment follow the steps below:

1. Install `certutil` (shipped with [NSS Tools](http://www.mozilla.org/projects/security/pki/nss/tools/))
- Apt (Debian-based systems): `libnss3-tools`
- Yum (RPM-based systems): `nss-tools`
- Portage: `dev-libs/nss [utils]`
2. Install a TLS certificate: `symfony server:ca:install`

# Configuring

In the project root directory, create `.env.local` file and specify the DSN as follows:
```
DATABASE_URL=mysql://salaryman:n2Nv69WvaVGwV4DM@127.0.0.1:3306/salaryman
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

- Go to the project root directory.
- Set Node.js environment:
```
# Development
export NODE_ENV=dev

# Production
export NODE_ENV=prod
```
- Install Composer packages:
```
# Development
composer install

# Production
composer install --no-dev
```
- Build frontend files:
```
# Development
yarn encore dev

#Production
yarn encore production
```
- Apply database migrations:
```
php bin/console doctrine:migrations:migrate
```

# Running

For development, you can use the [Symfony local Web server](https://symfony.com/doc/current/setup/symfony_server.html), if you don't want to configure Nginx or Apache.

In production environment, use a Web server such as Nginx, or Apache.

# Testing

- Build the project in "development" mode (see "Installing" section above).
- Change to the project root, then run: `./bin/phpunit`.

# License

MIT

© 2019 Ruslan Osmanov <rrosmanov@gmail.com>
