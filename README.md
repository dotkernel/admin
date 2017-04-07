# admin

Dotkernel web starter package suitable for admin applications.

## Requirements
* Admin application require PHP >= 7.1
* In order to use the default setup and import the database files, you need MySQL

## Installation

Create a new project directory and change dir to it. Run the following composer command
```bash
$ composer create-project dotkernel/admin .
```

The setup script will prompt for some custom settings. When encountering a question like the one below:

```shell
Please select which config file you wish to inject 'Zend\Session\ConfigProvider' into:
  [0] Do not inject
  [1] config/config.php
  Make your selection (default is 0):
```

For this option select `[0] Do not inject` because the frontend application  already has an injected config provider which already contains the prompted configurations.

`Remember this option for other packages of the same type? (y/N)`
`y`
The `ConfigProvider`'s can be left un-injected as the requested configurations are already loaded.

## Configuration

* import the database schema, if you are using mysql, found in `data/admin.sql`
* if using admin and frontend together, you can import the `admin+frontend.sql` database file
* remove the `.dist` extension of the file `local.php.dist` located in `config/autoload`
* edit `local.php` according to your dev machine. Fill in the `database` configuration and mail configuration
* if you use the create-project command, after installation, the project will go into development mode automatically
* you can also toggle development mode by using the composer commands
```bash
$ composer development-enable
$ composer development-disable
```

* if not already done on installation, copy file `development.global.php.dist` to `development.global.php`

This will enable dev mode having debug flag true and configuration caching off. It also make sure that any previously config cache is cleared.

**Do not enable dev mode in production**

* Next, run the following command in your project's directory
```bash
$ php -S 0.0.0.0:8080 -t public
```
* visit `http://localhost:8080` in your browser

**NOTE:**
If you are still getting exceptions or errors regarding some missing services, try running the following command
```bash
$ composer clear-config-cache
```

**NOTE**
If you get errors when running composer commands like development-enable or clear-config-cache related to parsing errors and strict types
it is probably because you don't have the PHP CLI version > 7.1 installed

If you cannot use these commands(for example if you cannot upgrade PHP globally) you can setup/clean the project by hand as described below or if you have a locally installed PHP 7.1 version installed you can use that
* enable development mode by renaming the files `config/development.config.php.dist` and `config/autoload/development.local.php.dist` to removed the `.dist` extension
* disable dev mode by reverting the above procedure
* run `bin/clear-config-cache.php` using the proper PHP version if accessible OR
* manually clear cached data from `data/cache` directory and optionally `data/proxies`

