# Dotkernel Admin

Dotkernel Admin is an application (skeleton) intended for quickly setting up an administration site for your platform.
It's a fast and reliable way to manage records in your database with a simple table-based approach, and also to build reports and graphs to monitor your platform.
The many graphical components at your disposal ensure an intuitive user experience.

> Check out our [demo](https://admin7.dotkernel.net/).
>
> Submit user `admin` and password `dotadmin` to authenticate yourself.

## Documentation

Documentation is available at: https://docs.dotkernel.org/admin-documentation/

## Version History

| Branch | Release  | PSR-11 | OSS Lifecycle                                                                                                                          | PHP Version                                                                                           |
|--------|----------|--------|----------------------------------------------------------------------------------------------------------------------------------------|-------------------------------------------------------------------------------------------------------|
| 7.0    | `>= 7.2` | 1      | ![OSS Lifecycle](https://img.shields.io/osslifecycle?file_url=https%3A%2F%2Fgithub.com%2Fdotkernel%2Fadmin%2Fblob%2F7.0%2FOSSMETADATA) | ![PHP from Packagist (specify version)](https://img.shields.io/packagist/php-v/dotkernel/admin/7.2.0) |
| 7.0    | `< 7.2`  | 1      | ![OSS Lifecycle](https://img.shields.io/osslifecycle?file_url=https%3A%2F%2Fgithub.com%2Fdotkernel%2Fadmin%2Fblob%2F7.0%2FOSSMETADATA) | ![PHP from Packagist (specify version)](https://img.shields.io/packagist/php-v/dotkernel/admin/7.1.0) |
| 6.0    | `< 7.0`  | 1      | ![OSS Lifecycle](https://img.shields.io/osslifecycle?file_url=https%3A%2F%2Fgithub.com%2Fdotkernel%2Fadmin%2Fblob%2F6.0%2FOSSMETADATA) | ![PHP from Packagist (specify version)](https://img.shields.io/packagist/php-v/dotkernel/admin/6.2.0) |
| 5.0    | `< 6.0`  | 1      | ![OSS Lifecycle](https://img.shields.io/osslifecycle?file_url=https%3A%2F%2Fgithub.com%2Fdotkernel%2Fadmin%2Fblob%2F5.0%2FOSSMETADATA) | ![PHP from Packagist (specify version)](https://img.shields.io/packagist/php-v/dotkernel/admin/5.0.3) |
| 4.0    | `< 5.0`  | 1      | ![OSS Lifecycle](https://img.shields.io/osslifecycle?file_url=https%3A%2F%2Fgithub.com%2Fdotkernel%2Fadmin%2Fblob%2F4.0%2FOSSMETADATA) | ![PHP from Packagist (specify version)](https://img.shields.io/packagist/php-v/dotkernel/admin/4.3.1) |
| 3.0    | `< 4.0`  | 1      | ![OSS Lifecycle](https://img.shields.io/osslifecycle?file_url=https%3A%2F%2Fgithub.com%2Fdotkernel%2Fadmin%2Fblob%2F3.0%2FOSSMETADATA) | ![PHP from Packagist (specify version)](https://img.shields.io/packagist/php-v/dotkernel/admin/3.2.1) |

## Badges

![OSS Lifecycle](https://img.shields.io/osslifecycle/dotkernel/admin)
![Packagist Dependency Version](https://img.shields.io/packagist/dependency-v/dotkernel/admin/php)

[![GitHub issues](https://img.shields.io/github/issues/dotkernel/admin)](https://github.com/dotkernel/admin/issues)
[![GitHub forks](https://img.shields.io/github/forks/dotkernel/admin)](https://github.com/dotkernel/admin/network)
[![GitHub stars](https://img.shields.io/github/stars/dotkernel/admin)](https://github.com/dotkernel/admin/stargazers)
[![GitHub license](https://img.shields.io/github/license/dotkernel/admin)](https://github.com/dotkernel/admin/blob/7.0/LICENSE.md)

[![Build Static](https://github.com/dotkernel/admin/actions/workflows/continuous-integration.yml/badge.svg?branch=7.0)](https://github.com/dotkernel/admin/actions/workflows/continuous-integration.yml)
[![codecov](https://codecov.io/gh/dotkernel/admin/graph/badge.svg?token=BQS43UWAM4)](https://codecov.io/gh/dotkernel/admin)
[![Qodana](https://github.com/dotkernel/admin/actions/workflows/qodana_code_quality.yml/badge.svg?branch=7.0)](https://github.com/dotkernel/admin/actions/workflows/qodana_code_quality.yml)
[![PHPStan](https://github.com/dotkernel/admin/actions/workflows/static-analysis.yml/badge.svg?branch=7.0)](https://github.com/dotkernel/admin/actions/workflows/static-analysis.yml)
[![Build Assets](https://github.com/dotkernel/admin/actions/workflows/build-assets.yml/badge.svg?branch=7.0)](https://github.com/dotkernel/admin/actions/workflows/build-assets.yml)

## Getting Started

### Clone the project

Using your terminal, navigate inside the directory you want to download the project files into.
Make sure that the directory is empty before proceeding to the download process.
Once there, run the following command:

```shell
git clone https://github.com/dotkernel/admin.git .
```

### Install the project dependencies

```shell
composer install
```

You will be prompted with the below message to choose whether you want to inject ConfigProviders:

```shell
 Please select which config file you wish to inject 'Laminas\Validator\ConfigProvider' into:
  [0] Do not inject
  [1] config/config.php
  Make your selection (default is 1):
```

Type `0` to select **[0] Do not inject** and hit `Enter`.

We choose not to inject any ConfigProvider because Dotkernel Admin comes with all the required ConfigProviders already injected in `config/config.php`.
Choosing to inject any extra ConfigProvider would cause having duplicates which are not allowed and would crash the application.

### Development mode

> **Do not enable development mode in production!**

If you're installing the project for development, you should **enable** development mode by running:

```shell
composer development-enable
```

You can **disable** development mode by running:

```shell
composer development-disable
```

You can **check** the development status by running:

```shell
composer development-status
```

### Prepare config files

* **optional**: to run/create tests, duplicate `config/autoload/local.test.php.dist` as `config/autoload/local.test.php` <- this creates a new in-memory database that your tests will run on

### Setup database

Use an existing empty one or create a new **MariaDB**/**MySQL** database.

> Recommended collation: `utf8mb4_general_ci`.

With a database created, fill out the database connection params in `config/autoload/local.php` under `$databases['default']`.

#### Creating migrations

Create a new migration by running:

```shell
php ./vendor/bin/doctrine-migrations diff
```

The new migration file will be placed in `src/Core/src/App/src/Migration/`.

#### Running migrations

Execute a new migration by running:

```shell
php ./vendor/bin/doctrine-migrations migrate
```

This command will prompt you to confirm that you want to run it:

> WARNING! You are about to execute a migration in database "`<database>`" that could result in schema changes and data loss. Are you sure you wish to continue? (yes/no) [yes]:

Hit `Enter` to confirm the operation.

#### Executing fixtures

Fixtures are used to seed the database with initial values and must be executed after migrating the database.

To list all the fixtures, run:

```shell
php ./bin/doctrine fixtures:list
```

This will output all the fixtures in the order of execution.

To execute all fixtures, run:

```shell
php ./bin/doctrine fixtures:execute
```

To execute a specific fixture, run:

```shell
php ./bin/doctrine fixtures:execute --class=FixtureClassName
```

More details on how fixtures work can be found in `dotkernel/dot-data-fixtures` [documentation](https://github.com/dotkernel/dot-data-fixtures#creating-fixtures).

### Mail configuration

If your application sends emails, you must configure an outgoing mail server under `config/autoload/mail.global.php`.

### Sync GeoLite2 databases

#### Full sync

You can download/update all GeoLite2 databases at once by running the following command:

```shell
php ./bin/cli.php geoip:synchronize
```

The output should be similar to the below:

```shell
asn: n/a -> 2015-10-21 04:29:00
city: n/a -> 2015-10-21 04:29:00
country: n/a -> 2015-10-21 04:29:00
```

#### Selective sync

You can download/update a specific GeoLite2 database by running the following command:

```shell
php ./bin/cli.php geoip:synchronize -d <database>
```

Where `<database>` takes one of the following values: **asn**, **city**, **country**.

Get help for this command by running:

```shell
php ./bin/cli.php help geoip:synchronize
```

> If you set up the synchronizer command as a cronjob, you can add the `-q|--quiet` option, and it will output data only if an error has occurred.

### NPM Commands

To install dependencies into the `node_modules` directory run this command:

```shell
npm install
```

If the above command fails, it could be caused by user permissions of `npm`.
Recommendation is to install npm through `Node Version Manager`.

The **watch** command looks for JavaScript/CSS file changes and recompiles the assets under the public assets:

```shell
npm run watch
```

Once finished working on the JavaScript/CSS files, run the below command to minify the public assets and prepare them for production:

```shell
npm run prod
```

### Test the installation

If you are using virtual hosts as described in the [Dotkernel documentation] (https://docs.dotkernel.org/development/), you need to modify the permissions of the `data`, `public/uploads` and `log` folders:

```shell
chmod -R 777 data
chmod -R 777 public/uploads
chmod -R 777 log
```

Run the following command in your project's directory to start PHPs built-in server:

```shell
php -S 0.0.0.0:8080 -t public
```

> Running command `composer serve` will do the same thing, but the server will time out after a couple of minutes.

If you are still getting exceptions or errors regarding some missing services, try running the following command:

```shell
php ./bin/clear-config-cache.php
```

Open a web browser and visit `http://localhost:8080/`.

You should see the **Dotkernel Admin** login page.
If you ran the migrations, you will have an admin user in the database with the following credentials:

* **Identity**: `admin`
* **Password**: `dotadmin`

---

> [!WARNING]
> **Production only**
>
> Make sure you modify the default admin credentials.

---

> [!WARNING]
> **Development only**
>
> `session.cookie_secure` does not work locally so make sure you modify your `local.php`, as per the following:

```php
return [
  'session_config' => [
    'cookie_secure' => false,
  ],
];
```

Do not change this in `local.php.dist` as well because this value must remain `true` on production.
