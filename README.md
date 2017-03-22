# dot-admin

Dotkernel web starter package suitable for admin applications.

## Installation

Create a new project directory and change dir to it. Run the following composer command
```bash
$ composer create-project dotkernel/dot-admin .
```

## Configuration

* import the database schema, if you are using mysql, found in `data/dot-frontend.sql`
* if using admin and frontend, you can import the `dot-admin+frontend.sql` database
* remove the `.dist` extension of the files `local.php.dist` located in `config/autoload`
* edit `local.php` according to your dev machine. Fill in the `database` configuration and mail configuration
* run the following command in your project root dir
* if you use the create-project command, after installing, the project will go into development mode automatically
* you can also toggle development mode by using the composer commands
```bash
$ composer development-enable
$ composer development-disable
```
This will enable dev mode having debug flag true and configuration caching off. It also make sure that any previously config cache is cleared.

**Do not enable dev mode in production**

* Next, run the following command in your project's directory
```bash
$ php -S 0.0.0.0:8080 -t public
```
* visit `http://localhost:8080` in your browser

**NOTE:**
If you still get exceptions or errors regarding some missing services, try running the following command
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

