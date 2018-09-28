# Introduction

This component provides an HTTP Basic Authentication adapter for
[zend-expressive-authentication](https://docs.zendframework.com/zend-expressive-authentication).

HTTP Basic authentication utilizes the user-info section of the URL authority in
order to provide credentials. While the HTTP specifications allow a single value
for the user-info, most implementations require a `:`-separated credential, with
the username first, and the password second; in fact, this is how browsers
always send HTTP Basic credentials, as their prompts are always for the two
values. As such, **this implementation expects both a username and password in
the supplied credentials**.

> ### Only use in trusted networks
>
> Since HTTP Basic transmits the credentials via the URL, it should only be used
> within trusted networks, and never in public-facing sites, as the URL can be
> sniffed by MITM proxies.

## Configuration

To use the adapter, you will need to provide the following configuration:

- A valid zend-expressive-authentication `UserRepositoryInterface` service in
  your DI container. This service will perform the actual work of validating the
  supplied credentials.

- An HTTP Basic **realm**. This may be an arbitrary value, but is [required by
  the specification](https://tools.ietf.org/html/rfc7617#section-2).

- A response factory. If you are using Expressive, this is already configured
  for you.

As an example of configuration:

```php
// config/autoload/authentication.global.php

use Zend\Expressive\Authentication\AdapterInterface;
use Zend\Expressive\Authentication\Basic\BasicAccess;
use Zend\Expressive\Authentication\UserRepositoryInterface;
use Zend\Expressive\Authentication\UserRepository\PdoDatabase;

return [
    'dependencies' => [
        'aliases' => [
            // Use the default PdoDatabase user repository. This assumes
            // you have configured that service correctly.
            UserRepositoryInterface::class => PdoDatabase::class,

            // Tell zend-expressive-authentication to use the BasicAccess
            // adapter:
            AdapterInterface::class => BasicAccess::class,
        ],
    ],
    'authentication' => [
        'realm' => 'api',
    ],
];
```

## Usage

Whenever you need an authenticated user, you can place the
zend-expressive-authentication `AuthenticationMiddleware` in your pipeline.

### Globally

If you need all routes to use authentication, add it globally.

```php
// In config/pipeline.php, within the callback:

$app->pipe(Zend\Expressive\Authentication\AuthenticationMiddleware::class);
```

### For an entire sub-path

If you need all routes that begin with a particular sub-path to require
authentication, use [path-segregation](https://docs.zendframework.com/zend-stratigility/v3/api/#path):

```php
// In config/pipeline.php.
// In the import statements:
use Zend\Expressive\Authentication\AuthenticationMiddleware;

// In the callback:
$app->pipe('/api', $factory->path(
    $factory->prepare(AuthenticationMiddleware::class)
));
```

### For a specific route

If you want to restrict access for a specific route, create a [route-specific
middleware pipeline](https://docs.zendframework.com/zend-expressive/v3/cookbook/route-specific-pipeline/):

```php
// In config/routes.php, in the callback:

$app->get(
    '/path/requiring/authentication',
    [
        Zend\Expressive\Authentication\AuthenticationMiddleware::class,
        HandlerRequiringAuthentication::class, // use your own handler here
    ]
);
```