<?php
/**
 * @see       https://github.com/zendframework/zend-expressive-authentication-basic for the canonical source repository
 * @copyright Copyright (c) 2017-2018 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   https://github.com/zendframework/zend-expressive-authentication-basic/blob/master/LICENSE.md
 *     New BSD License
 */

namespace Zend\Expressive\Authentication\Basic;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Expressive\Authentication\AuthenticationInterface;
use Zend\Expressive\Authentication\UserInterface;
use Zend\Expressive\Authentication\UserRepositoryInterface;

use function base64_decode;
use function explode;
use function preg_match;
use function sprintf;

class BasicAccess implements AuthenticationInterface
{
    /**
     * @var UserRepositoryInterface
     */
    protected $repository;

    /**
     * @var string
     */
    protected $realm;

    /**
     * @var callable
     */
    protected $responseFactory;

    public function __construct(
        UserRepositoryInterface $repository,
        string $realm,
        callable $responseFactory
    ) {
        $this->repository = $repository;
        $this->realm = $realm;

        // Ensures type safety of the composed factory
        $this->responseFactory = function () use ($responseFactory) : ResponseInterface {
            return $responseFactory();
        };
    }

    public function authenticate(ServerRequestInterface $request) : ?UserInterface
    {
        $authHeaders = $request->getHeader('Authorization');

        if (1 !== count($authHeaders)) {
            return null;
        }

        [$authHeader] = $authHeaders;

        if (! preg_match('/Basic (?P<credentials>.+)/', $authHeader, $match)) {
            return null;
        }

        $decodedCredentials = base64_decode($match['credentials'], true);

        if (false === $decodedCredentials) {
            return null;
        }

        $credentialParts = explode(':', $decodedCredentials, 2);

        if (false === $credentialParts) {
            return null;
        }

        if (2 !== count($credentialParts)) {
            return null;
        }

        [$username, $password] = $credentialParts;

        return $this->repository->authenticate($username, $password);
    }

    public function unauthorizedResponse(ServerRequestInterface $request) : ResponseInterface
    {
        return ($this->responseFactory)()
            ->withHeader(
                'WWW-Authenticate',
                sprintf('Basic realm="%s"', $this->realm)
            )
            ->withStatus(401);
    }
}
