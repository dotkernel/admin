DotKernel3 Migration
---

Migration from Zend Expressive 2 to 3.


## Packages

In `composer.json` replace the matching repositories with the following:

```  
"dotkernel/dot-authentication-service":"^1.0",
"dotkernel/dot-authentication-web":"^1.0.1",
"dotkernel/dot-authentication":"^1.0"
"dotkernel/dot-controller":"^1.0",
"dotkernel/dot-controller-plugin-authentication":"^1.0",
"dotkernel/dot-controller-plugin-authorization":"^1.0",
"dotkernel/dot-controller-plugin-flashmessenger":"^1.0",
"dotkernel/dot-controller-plugin-forms":"^1.0",
"dotkernel/dot-controller-plugin-mail":"^1.0",
"dotkernel/dot-controller-plugin-session":"^1.0",
"dotkernel/dot-flashmessenger":"^1.0",
"dotkernel/dot-helpers":"^1.0",
"dotkernel/dot-mail":"^1.0",
"dotkernel/dot-mapper":"^1.0",
"dotkernel/dot-navigation":"^1.0",
"dotkernel/dot-rbac":"^0.2.1",
"dotkernel/dot-rbac-guard":"^1.0",
"dotkernel/dot-session":"^3.0",
"dotkernel/dot-twigrenderer":"^1.1",
"dotkernel/dot-user":"^1.0",

"zendframework/zend-stratigility": "^3.0",
"zendframework/zend-expressive": "^3.0",
"zendframework/zend-expressive-template": "^2.0",
"zendframework/zend-expressive-router": "^3.0",
"zendframework/zend-expressive-fastroute": "^3.0",
"zendframework/zend-expressive-tooling": "^1.0",
```
also update require-dev dependencies
```
"zendframework/zend-expressive-tooling:": "^1.0",
"zendframework/zend-component-installer": "^2.0",

```

Remove packages: 
* http-interop/http-middleware 
* webimpress/http-middleware-compatibility
```
composer require dotkernel/dot-authentication-service:^1.0\
 dotkernel/dot-authentication-service:^1.0\
 dotkernel/dot-authentication-web:^1.0.1\
 dotkernel/dot-authentication:^1.0\
 dotkernel/dot-controller:^1.0\
 dotkernel/dot-controller-plugin-authentication:^1.0\
 dotkernel/dot-controller-plugin-authorization:^1.0\
 dotkernel/dot-controller-plugin-forms:^1.0\
 dotkernel/dot-controller-plugin-flashmessenger:^1.0\
 dotkernel/dot-controller-plugin-mail:^1.0\
 dotkernel/dot-controller-plugin-session:^1.0\
 dotkernel/dot-flashmessenger:^1.0\
 dotkernel/dot-helpers:^1.0\
 dotkernel/dot-mail:^1.0\
 dotkernel/dot-mapper:^1.0\
 dotkernel/dot-navigation:^1.0\
 dotkernel/dot-rbac-guard:^1.0\
 dotkernel/dot-session:^3.0\
 dotkernel/dot-twigrenderer:^1.1\
 dotkernel/dot-user:^1.0\
 dotkernel/dot-rbac:^0.2.1\
 zendframework/zend-expressive-helpers:^5.0\
 zendframework/zend-expressive-twigrenderer:^2.0\
 zendframework/zend-expressive-template:^2.0\
 zendframework/zend-expressive:^3.0\
 zendframework/zend-expressive-fastroute:^3.0\
 zendframework/zend-expressive-tooling:^1.0\
 zendframework/zend-expressive-router:^3.0\
 zendframework/zend-stratigility:^3.0\
 zendframework/zend-component-installer:^2.0

composer remove http-interop/http-middleware\
 webimpress/http-middleware-compatibility


```

## Configurations

### Main Configuration
In `config/config.php` add the following config providers:

```php
// zend expressive & middleware factory
\Zend\Expressive\ConfigProvider::class,

// router config
\Zend\Expressive\Router\ConfigProvider::class,
\Zend\Expressive\Router\FastRouteRouter\ConfigProvider::class,

\Zend\Expressive\Twig\ConfigProvider::class,
\Zend\Expressive\Helper\ConfigProvider::class,

// handler runner
\Zend\HttpHandlerRunner\ConfigProvider::class,
```

Make sure they are the first ConfigProviders or before cached config (`ArrayProvider`)	

### Routing

Wrap routing from `config/routes.php` in a callable with the following format:

```php
return function (Application $app, MiddlewareFactory $factory, ContainerInterface $container) : void {
    /** @var \Zend\Expressive\Application $app */
    $app->route('/', [PageController::class], ['GET', 'POST'], 'home');
};
```

add the following use statements and make sure the names are not duplicate:

```php
use Psr\Container\ContainerInterface;
use Zend\Expressive\Application;
use Zend\Expressive\MiddlewareFactory;
```

### Pipeline

Wrap routing from `config/pipeline.php` in a callable with the following format:

```php
return function (Application $app, MiddlewareFactory $factory, ContainerInterface $container) : void {
    /** @var \Zend\Expressive\Application $app */
    $app->route('/', [PageController::class], ['GET', 'POST'], 'home');
};
```

add the following use statements and make sure the names are not duplicate:

```php
use Psr\Container\ContainerInterface;
use Zend\Expressive\Application;
use Zend\Expressive\MiddlewareFactory;
```


#### Routing middleware migration

add the following use statements
```php
use Zend\Expressive\Router\Middleware\RouteMiddleware;
use Zend\Expressive\Router\Middleware\DispatchMiddleware;
```

Replace the following lines to reflect the changes:

`$app->pipeRoutingMiddleware();` -> `$app->pipe(RouteMiddleware::class);`
`$app->pipeDispatchMiddleware();` -> `$app->pipe(DispatchMiddleware::class);`









