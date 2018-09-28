# Configuration

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
