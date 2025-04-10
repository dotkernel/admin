# Dotkernel Admin

Dotkernel Admin is an application (skeleton) intended for quickly setting up an administration site for your platform.
It's a fast and reliable way to manage records in your database with a simple table-based approach, and also to build reports and graphs to monitor your platform.
The many graphical components at your disposal ensure an intuitive user experience.

> Check out our [demo](https://admin5.dotkernel.net/).
>
> Submit user `admin` and password `dotadmin` to authenticate yourself.

## Documentation

Documentation is available at: https://docs.dotkernel.org/admin-documentation/

## Badges

![OSS Lifecycle](https://img.shields.io/osslifecycle/dotkernel/admin)
![PHP from Packagist (specify version)](https://img.shields.io/packagist/php-v/dotkernel/admin/5.0.0)

[![GitHub issues](https://img.shields.io/github/issues/dotkernel/admin)](https://github.com/dotkernel/admin/issues)
[![GitHub forks](https://img.shields.io/github/forks/dotkernel/admin)](https://github.com/dotkernel/admin/network)
[![GitHub stars](https://img.shields.io/github/stars/dotkernel/admin)](https://github.com/dotkernel/admin/stargazers)
[![GitHub license](https://img.shields.io/github/license/dotkernel/admin)](https://github.com/dotkernel/admin/blob/5.0/LICENSE.md)

[![Build Static](https://github.com/dotkernel/admin/actions/workflows/continuous-integration.yml/badge.svg?branch=5.0)](https://github.com/dotkernel/admin/actions/workflows/continuous-integration.yml)
[![codecov](https://codecov.io/gh/dotkernel/admin/graph/badge.svg?token=BQS43UWAM4)](https://codecov.io/gh/dotkernel/admin)
[![Qodana](https://github.com/dotkernel/admin/actions/workflows/qodana_code_quality.yml/badge.svg?branch=5.0)](https://github.com/dotkernel/admin/actions/workflows/qodana_code_quality.yml)
[![PHPStan](https://github.com/dotkernel/admin/actions/workflows/static-analysis.yml/badge.svg?branch=5.0)](https://github.com/dotkernel/admin/actions/workflows/static-analysis.yml)

## Installing Dotkernel `admin`

## Tools

Dotkernel can be installed through a single command that utilizes [Composer](https://getcomposer.org/).
Because of that, Composer is required to install Dotkernel Admin.

### Composer

Installation instructions:

- [Composer Installation - Linux/Unix/OSX](https://getcomposer.org/doc/00-intro.md#installation-linux-unix-osx)
- [Composer Installation - Windows](https://getcomposer.org/doc/00-intro.md#installation-windows)

> If you have never used composer before make sure you read the [`Composer Basic Usage`](https://getcomposer.org/doc/01-basic-usage.md) section in Composer's documentation.

## Choosing an installation path for Dotkernel Admin

Example:

- absolute path `/var/www/dk-admin`
- or relative path `dk-admin` (equivalent with `./dk-admin`)

## Installing Dotkernel Admin

After choosing the path for Dotkernel (`dk-admin` will be used for the remainder of this example) it must be installed.
There are two installation methods.

### I. Installing Dotkernel Admin using Composer

> please use the below CLI commands in terminal, do NOT use the PhpStorm buttons

The advantage of using this command is that it runs through the whole installation process. Run the following command:

```shell
composer create-project dotkernel/admin -s dev dk
```

The above command downloads the `admin` package, then downloads and installs the `dependencies`.

The setup script prompts for some configuration settings, for example the lines below:

```text
Please select which config file you wish to inject 'Laminas\Diactoros\ConfigProvider' into:
  [0] Do not inject
  [1] config/config.php
  Make your selection (default is 1):
```

Simply select `[0] Do not inject`, because Dotkernel includes its own configProvider which already contains the prompted configurations.

If you choose `[1] config/config.php` Laminas' `ConfigProvider` from `session` will be injected.

The next question is:

```shell
Remember this option for other packages of the same type? (y/N)
```

Type `y` here, and hit `Enter`.

### II. Installing Dotkernel Admin using git clone

This method requires more manual input, but it ensures that the default branch is installed, even if it is not released.
Run the following command:

```shell
git clone https://github.com/dotkernel/admin.git .
```

The dependencies have to be installed separately, by running this command

```shell
composer install
```

Just like when [Installing Dotkernel admin using Composer](#i-installing-dotkernel-admin-using-composer), the setup asks for configuration settings regarding injections (type `0` and hit `enter`) and the confirmation to use this setting for other packages (type `y` and hit `Enter`).

## Configuration - First Run

- Remove the `.dist` extension from the files `config/autoload/local.php.dist`
- Edit `config/autoload/local.php` according to your dev machine and fill in the `database` configuration

> Charset recommendation: utf8mb4_general_ci

Run the migrations and seeds with these commands:

```shell
php ./bin/doctrine-migrations migrate
```

```shell
php ./bin/doctrine fixtures:execute
```

- If you use `composer create-project`, the project will go into development mode automatically after installing.

The development mode status can be checked and toggled by using the below Composer commands:

Check development status by running:

```shell
composer development-status
```

Enable development mode by running:

```shell
composer development-enable
```

Disable development mode by running:

```shell
composer development-disable
```

- If not already done on installation, remove the `.dist` extension from `config/autoload/development.global.php.dist`.

This will enable dev mode by turning debug flag to `true` and turning configuration caching to `off`.
It will also make sure that any existing config cache is cleared.

## Manage GeoLite2 database

You can download/update a specific GeoLite2 database, by running the following command:

```shell
php ./bin/cli.php geoip:synchronize -d {DATABASE}
```

Where _{DATABASE}_ takes one of the following values: `asn`, `city`, `country`.

You can download/update all GeoLite2 databases at once, by running the following command:

```shell
php ./bin/cli.php geoip:synchronize
```

The output should be similar to the below, displaying per row:

```shell
asn: n/a -> 2015-10-21 04:29:00
city: n/a -> 2015-10-21 04:29:00
country: n/a -> 2015-10-21 04:29:00
```

Get help for this command by running:

```shell
php ./bin/cli.php help geoip:synchronize
```

> If you set up the synchronizer command as a cronjob, you can add the `-q|--quiet` option, and it will output data only if an error has occurred.

## NPM Commands

To install dependencies into the `node_modules` directory run this command.

```shell
npm install
```

If `npm install` fails, this could be caused by user permissions of npm.
Recommendation is to install npm through `Node Version Manager`.

The watch command compiles the components then watches the files and recompiles when one of them changes.

```shell
npm run watch
```

After all updates are done, this command compiles the assets locally, minifies them and makes them ready for production.

```shell
npm run prod
```

## Authorization Guards

The packages responsible for restricting access to certain parts of the application are [dot-rbac-guard](https://github.com/dotkernel/dot-rbac-guard) and [dot-rbac](https://github.com/dotkernel/dot-rbac).
These packages work together to create an infrastructure that is customizable and diversified to manage user access to the platform by specifying the type of role the user has.

The `authorization.global.php` file provides multiple configurations specifying multiple roles as well as the types of permissions to which these roles have access.

```php
  'roles' => [
      'superuser' => [
          'permissions' => [
              'authenticated',
              'edit',
              'delete',
              //etc..
          ]
      ],
      'admin' => [
          'permissions' => [
              'authenticated',
              //etc..
          ]
      ]
  ]
```

The `authorization-guards.global.php` file provides configuration to restrict access to certain actions based on the permissions defined in `authorization.global.php` so basically we have to add the permissions in the dot-rbac configuration file first to specify the action restriction permissions.

```php
  'rules' => [
    [
        'route' => 'account',
        'actions' => [//list of actions to apply , or empty array for all actions
            'unregister',
            'avatar',
            'details',
            'changePassword'
        ],
        'permissions' => ['authenticated']
    ],
    [
        'route' => 'admin',
        'actions' => [
            'deleteAccount'
        ],
         'permissions' => [
            'delete'
            //list of roles to allow
        ]
    ]
  ]
```

## Testing (Running) the application

> **Do not enable dev mode in production**

- Run the following command in your project's directory to start PHPs built-in server:

```shell
php -S 0.0.0.0:8080 -t public
```

> Running command `composer serve` will do the exact same, but the above is faster.

`0.0.0.0` means that the server is open to all incoming connections
`127.0.0.1` means that the server can only be accessed locally (localhost only)
`8080` the port on which the server is started (the listening port for the server)

> If you are still getting exceptions or errors regarding some missing services, try running the following command:

```shell
php ./bin/clear-config-cache.php
```

> If `config-cache.php` is present that config will be loaded regardless of the `ConfigAggregator::ENABLE_CACHE` in `config/autoload/mezzio.global.php`

- Open a web browser and visit `http://localhost:8080/`

You should see the `Dotkernel admin` login page.
If you ran the migrations you will have an admin user in the database with the following credentials:

- **User**: `admin`
- **Password**: `dotadmin`

> **Production only**: Make sure you modify the default admin credentials.
>
> **Development only**: `session.cookie_secure` does not work locally so make sure you modify your `local.php`, as per the following:

```php
    return [
      'session_config' => [
          'cookie_secure' => false,
      ]
    ];
```

Do not change this in `local.php.dist` as well because this value should remain `true` on production.
