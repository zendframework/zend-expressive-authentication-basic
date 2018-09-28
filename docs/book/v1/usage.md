# Usage

Whenever you need an authenticated user, you can place the
zend-expressive-authentication `AuthenticationMiddleware` in your pipeline.

## Globally

If you need all routes to use authentication, add it globally.

```php
// In config/pipeline.php, within the callback:

$app->pipe(Zend\Expressive\Authentication\AuthenticationMiddleware::class);
```

## For an entire sub-path

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

## For a specific route

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
