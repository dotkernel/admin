# frontend

Dotkernel web starter package suitable for frontend applications.

[![GitHub issues](https://img.shields.io/github/issues/dotkernel/frontend)](https://github.com/dotkernel/frontend/issues)
[![GitHub forks](https://img.shields.io/github/forks/dotkernel/frontend)](https://github.com/dotkernel/frontend/network)
[![GitHub stars](https://img.shields.io/github/stars/dotkernel/frontend)](https://github.com/dotkernel/frontend/stargazers)
[![GitHub license](https://img.shields.io/github/license/dotkernel/frontend)](https://github.com/dotkernel/frontend/blob/3.0/LICENSE.md)


![PHP from Packagist (specify version)](https://img.shields.io/packagist/php-v/dotkernel/frontend/3.0.x-dev)


# Installing DotKernel `frontend`

- [Installing DotKernel `frontend`](#installing-dotkernel-frontend)
    - [Installation](#installation)
        - [Composer](#composer)
    - [Choose a destination path for DotKernel `frontend` installation](#choose-a-destination-path-for-dotkernel-frontend-installation)
    - [Installing the `frontend` Composer package](#installing-the-frontend-composer-package)
        - [Installing DotKernel Frontend](#installing-dotkernel-frontend)
    - [Configuration - First Run](#configuration---first-run)
    - [Testing (Running)](#testing-running)

## Tools

DotKernel can be installed through a single command that utilizes [Composer](https://getcomposer.org/). Because of that, Composer is required to install DotKernel `frontend`.

### Composer

Installation instructions:

- [Composer Installation -  Linux/Unix/OSX](https://getcomposer.org/doc/00-intro.md#installation-linux-unix-osx)
- [Composer Installation - Windows](https://getcomposer.org/doc/00-intro.md#installation-windows)

> If you have never used composer before make sure you read the [`Composer Basic Usage`](https://getcomposer.org/doc/01-basic-usage.md) section in Composer's documentation

## Choosing an installation path for DotKernel `frontend` 

Example:

- absolute path `/var/www/dk`
- or relative path `dk` (equivalent with `./dk`)

## Installing DotKernel `frontend`

After choosing the path for DotKernel (`dk` will be used for the remainder of this example) it must be installed. There are two installation methods. 

#### I. Installing DotKernel `frontend` using composer 

The advantage of using this command is that it runs through the whole installation process. Run the following command:

```bash
$ composer create-project dotkernel/frontend -s dev dk
```

The above command downloads the `frontend` package, then downloads and installs the `dependencies`.

The setup script prompts for some configuration settings, for example the lines below:

```shell
Please select which config file you wish to inject 'Laminas\Diactoros\ConfigProvider' into:
  [0] Do not inject
  [1] config/config.php
  Make your selection (default is 0):
```

Simply select `[0] Do not inject`, because DotKernel includes its own configProvider which already contains the prompted configurations.
If you choose `[1] config/config.php` Laminas's `ConfigProvider` from `session` will be injected.

The next question is:

`Remember this option for other packages of the same type? (y/N)`

Type `y` here, and hit `enter`

#### II. Installing DotKernel `frontend` using git clone

This method requires more manual input, but it ensures that the default branch is installed, even if it is not released. Run the following command:

```bash
$ git clone https://github.com/dotkernel/frontend.git .
```

The dependencies have to be installed separately, by running this command
```bash
$ composer install
```

Just like for `II Installing DotKernel frontend using composer` (see above), the setup asks for configuration settings regarding injections (type `0` and hit `enter`) and a confirmation to use this setting for other packages (type `y` and hit `enter`)

## Configuration - First Run

- Remove the `.dist` extension from the files `config/autoload/local.php.dist` and `config/autoload/mail.local.php.dist`
- Edit `config/autoload/local.php` according to your dev machine and fill in the `database` configuration
 
If you want your application to send mails on registration, contact... please provide valid credentials to the following keys in `config/autoload/mail.local.php`

Under `message_options` key:
- `from` - email address from whom users will receive emails

Under `smtp_options` key:
- `host` - hostname or IP address of the mail server
- `connection_config` - please complete the `username` and `password` keys

In `config/autoload/local.php` add under `contact` => `message_receivers` => `to` key *string* values with the emails that should receive contact messages


Run the migrations and seeds with these commands:

```bash
php vendor/bin/phinx migrate --configuration="config/migrations.php"
php vendor/bin/phinx seed:run --configuration="config/migrations.php"
```
- If you use `composer create-project`, the project will go into development mode automatically after installing. The development mode status can be checked and toggled by using these composer commands

```bash
$ composer development-status
$ composer development-enable
$ composer development-disable
```

- If not already done on installation, remove the `.dist` extension from `config/autoload/development.global.php.dist`.
This will enable dev mode by turning debug flag to `true` and turning configuration caching to `off`. It will also make sure that any existing config cache is cleared.

> Charset recommendation: utf8mb4_general_ci

## NPM Commands

To install dependencies into the `node_modules` directory run this command.
```bash
npm install
``` 
- If `npm install` fails, this could be caused by user permissions of npm. Recommendation is to install npm through `Node Version Manager`.

The watch command compiles the components then watches the files and recompiles when one of them changes.

```bash
npm run watch
```  

After all updates are done, this command compiles the assets locally, minifies them and makes them ready for production. 

```bash
npm run prod
```
## Authorization Guards
The packages responsible for restricting access to certain parts of the application are [dot-rbac-guard](https://github.com/dotkernel/dot-rbac-guard) and [dot-rbac](https://github.com/dotkernel/dot-rbac). These packages work together to create an infrastructure that is customizable and diversified to manage user access to the platform by specifying the type of role the user has.

The `authorization.global.php` file provides multiple configurations specifying multiple roles as well as the types of permissions to which these roles have access.

```php
//example of a flat RBAC model that specifies two types of roles as well as their permission
    'roles' => [
                'admin' => [
                    'permissions' => [
                        'authenticated',
                        'edit',
                        'delete',
                        //etc..
                    ]
                ],
                'user' => [
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

## Languages

The `local.php.dist` file provides an example for working with multiple languages. The `translator` variable can be expanded to other languages using [Poedit](https://poedit.net/) which can edit `.po` files like the example in `data/language/da_DK/LC_MESSAGES/messages.po`. The compiled file will have the extension `.mo`

To apply the translations 
- the twig templates need either `{% trans 'translateText' %}` or `{{ translateText|trans }}`
- then the js file needs `translateText("translateText")`


## Testing (Running)

Note: **Do not enable dev mode in production**

- Run the following command in your project's directory to start PHPs built-in server:

```bash
$ php -S 0.0.0.0:8080 -t public
```

> Running command `composer serve` will do the exact same, but the above is faster.

`0.0.0.0` means that the server is open to all incoming connections
`127.0.0.1` means that the server can only be accessed locally (localhost only)
`8080` the port on which the server is started (the listening port for the server)

**NOTE:**
If you are still getting exceptions or errors regarding some missing services, try running the following command

```php
php bin/clear-config-cache.php
```

> If `config-cache.php` is present that config will be loaded regardless of the `ConfigAggregator::ENABLE_CACHE` in `config/autoload/mezzio.global.php`

- Open a web browser and visit `http://localhost:8080/`

You should see the `DotKernel Frontend` welcome page.
