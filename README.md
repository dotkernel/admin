# admin

DotKernel web starter package suitable for admin applications.

![OSS Lifecycle](https://img.shields.io/osslifecycle/dotkernel/admin)
![PHP from Packagist (specify version)](https://img.shields.io/packagist/php-v/dotkernel/admin/4.3.0)

[![GitHub issues](https://img.shields.io/github/issues/dotkernel/admin)](https://github.com/dotkernel/admin/issues)
[![GitHub forks](https://img.shields.io/github/forks/dotkernel/admin)](https://github.com/dotkernel/admin/network)
[![GitHub stars](https://img.shields.io/github/stars/dotkernel/admin)](https://github.com/dotkernel/admin/stargazers)
[![GitHub license](https://img.shields.io/github/license/dotkernel/admin)](https://github.com/dotkernel/admin/blob/3.0/LICENSE.md)

[![Build Static](https://github.com/dotkernel/admin/actions/workflows/static-analysis.yml/badge.svg?branch=4.0)](https://github.com/dotkernel/admin/actions/workflows/static-analysis.yml)
[![Build Static](https://github.com/dotkernel/admin/actions/workflows/run-tests.yml/badge.svg?branch=4.0)](https://github.com/dotkernel/admin/actions/workflows/run-tests.yml)
[![codecov](https://codecov.io/gh/dotkernel/admin/graph/badge.svg?token=BQS43UWAM4)](https://codecov.io/gh/dotkernel/admin)

[![SymfonyInsight](https://insight.symfony.com/projects/6a7ecfc1-a0ed-4901-96ac-d0ff61f7b55f/big.svg)](https://insight.symfony.com/projects/6a7ecfc1-a0ed-4901-96ac-d0ff61f7b55f)


# Installing DotKernel `admin`

- [Installing DotKernel `admin`](#installing-dotkernel-admin)
    - [Installation](#installation)
        - [Composer](#composer)
    - [Choose a destination path for DotKernel `admin` installation](#choose-a-destination-path-for-dotkernel-admin-installation)
    - [Installing the `admin` Composer package](#installing-the-admin-composer-package)
        - [Installing DotKernel admin](#installing-dotkernel-admin)
    - [Configuration - First Run](#configuration---first-run)
    - [Manage GeoLite2 database](#manage-geolite2-database)
    - [Testing (Running)](#testing-running)

## Tools

DotKernel can be installed through a single command that utilizes [Composer](https://getcomposer.org/). Because of that, Composer is required to install DotKernel `admin`.


### Composer

Installation instructions:

- [Composer Installation - Linux/Unix/OSX](https://getcomposer.org/doc/00-intro.md#installation-linux-unix-osx)
- [Composer Installation - Windows](https://getcomposer.org/doc/00-intro.md#installation-windows)

> If you have never used composer before make sure you read the [`Composer Basic Usage`](https://getcomposer.org/doc/01-basic-usage.md) section in Composer's documentation


## Choosing an installation path for DotKernel `admin` 

Example:

- absolute path `/var/www/dk-admin`
- or relative path `dk-admin` (equivalent with `./dk-admin`)


## Installing DotKernel `admin`

After choosing the path for DotKernel (`dk-admin` will be used for the remainder of this example) it must be installed. There are two installation methods. 


#### I. Installing DotKernel `admin` using composer 

The advantage of using this command is that it runs through the whole installation process. Run the following command:

    composer create-project dotkernel/admin -s dev dk


The above command downloads the `admin` package, then downloads and installs the `dependencies`.

The setup script prompts for some configuration settings, for example the lines below:

    Please select which config file you wish to inject 'Laminas\Diactoros\ConfigProvider' into:
      [0] Do not inject
      [1] config/config.php
      Make your selection (default is 0):


Simply select `[0] Do not inject`, because DotKernel includes its own configProvider which already contains the prompted configurations.
If you choose `[1] config/config.php` Laminas's `ConfigProvider` from `session` will be injected.

The next question is:

`Remember this option for other packages of the same type? (y/N)`

Type `y` here, and hit `enter`


#### II. Installing DotKernel `admin` using git clone

This method requires more manual input, but it ensures that the default branch is installed, even if it is not released. Run the following command:

    git clone https://github.com/dotkernel/admin.git .


The dependencies have to be installed separately, by running this command

    composer install


Just like for `II Installing DotKernel admin using composer` (see above), the setup asks for configuration settings regarding injections (type `0` and hit `enter`) and a confirmation to use this setting for other packages (type `y` and hit `enter`)


## Configuration - First Run

- Remove the `.dist` extension from the files `config/autoload/local.php.dist`
- Edit `config/autoload/local.php` according to your dev machine and fill in the `database` configuration

Run the migrations and seeds with these commands:
```shell
  php bin/doctrine-migrations migrate
```
```shell
  php bin/doctrine fixtures:execute
```

- If you use `composer create-project`, the project will go into development mode automatically after installing. The development mode status can be checked and toggled by using these composer commands:
```shell
  composer development-status
```
```shell
  composer development-enable
```
```shell
  composer development-disable
```

- If not already done on installation, remove the `.dist` extension from `config/autoload/development.global.php.dist`.
This will enable dev mode by turning debug flag to `true` and turning configuration caching to `off`. It will also make sure that any existing config cache is cleared.

> Charset recommendation: utf8mb4_general_ci

## Manage GeoLite2 database

You can download/update a specific GeoLite2 database, by running the following command:

    php bin/cli.php geoip:synchronize -d {DATABASE}


Where _{DATABASE}_ takes one of the following values: `asn`, `city`, `country`.

You can download/update all GeoLite2 databases at once, by running the following command:

    php bin/cli.php geoip:synchronize


The output should be similar to the below, displaying per row: `database identifier`: `previous build datetime` -> `current build datetime`.

> asn: n/a -> 2021-07-01 02:09:34
> 
> city: n/a -> 2021-07-01 02:09:20
> 
> country: n/a -> 2021-07-01 02:05:12

Get help for this command by running:

    php bin/cli.php help geoip:synchronize


**Tip**: If you setup the synchronizer command as a cronjob, you can add the `-q|--quiet` option, and it will output data only if an error has occurred.


## NPM Commands

To install dependencies into the `node_modules` directory run this command.

    npm install


If `npm install` fails, this could be caused by user permissions of npm. Recommendation is to install npm through `Node Version Manager`.

The watch command compiles the components then watches the files and recompiles when one of them changes.

    npm run watch


After all updates are done, this command compiles the assets locally, minifies them and makes them ready for production. 

    npm run prod


## Authorization Guards
The packages responsible for restricting access to certain parts of the application are [dot-rbac-guard](https://github.com/dotkernel/dot-rbac-guard) and [dot-rbac](https://github.com/dotkernel/dot-rbac). These packages work together to create an infrastructure that is customizable and diversified to manage user access to the platform by specifying the type of role the user has.

The `authorization.global.php` file provides multiple configurations specifying multiple roles as well as the types of permissions to which these roles have access.

```php
//example of a flat RBAC model that specifies two types of roles as well as their permission
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
//example of configuration example to restrict certain actions of some routes based on the permissions specified in the dot-rbac configuration file
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

## Testing (Running)

Note: **Do not enable dev mode in production**

- Run the following command in your project's directory to start PHPs built-in server:
```shell
  php -S 0.0.0.0:8080 -t public
```

> Running command `composer serve` will do the exact same, but the above is faster.

`0.0.0.0` means that the server is open to all incoming connections
`127.0.0.1` means that the server can only be accessed locally (localhost only)
`8080` the port on which the server is started (the listening port for the server)

**NOTE:**
If you are still getting exceptions or errors regarding some missing services, try running the following command

    php bin/clear-config-cache.php


> If `config-cache.php` is present that config will be loaded regardless of the `ConfigAggregator::ENABLE_CACHE` in `config/autoload/mezzio.global.php`

- Open a web browser and visit `http://localhost:8080/`

You should see the `DotKernel admin` login page.

If you ran the migrations you will have an admin user in the database with the following credentials:

- **User**: `admin`
- **Password**: `dotadmin`

**NOTE:**
- **Production only**: Make sure you modify the default admin credentials.
- **Development only**: `session.cookie_secure` does not work locally so make sure you modify your `local.php`, as per the following:
```php
# other code

return [
    # other configurations...
    'session_config' => [
        'cookie_secure' => false,
    ],
];
```
Do not change this in `local.php.dist` as well because this value should remain `true` on production.
