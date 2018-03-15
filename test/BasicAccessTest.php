<?php
/**
 * @see       https://github.com/zendframework/zend-expressive-authentication-basic for the canonical source repository
 * @copyright Copyright (c) 2017-2018 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   https://github.com/zendframework/zend-expressive-authentication-basic/blob/master/LICENSE.md
 *     New BSD License
 */

namespace ZendTest\Expressive\Authentication\Basic;

use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\Prophecy\ObjectProphecy;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Expressive\Authentication\AuthenticationInterface;
use Zend\Expressive\Authentication\Basic\BasicAccess;
use Zend\Expressive\Authentication\UserInterface;
use Zend\Expressive\Authentication\UserRepositoryInterface;

class BasicAccessTest extends TestCase
{
    /** @var ServerRequestInterface|ObjectProphecy */
    private $request;

    /** @var UserRepositoryInterface|ObjectProphecy */
    private $userRepository;

    /** @var UserInterface|ObjectProphecy */
    private $authenticatedUser;

    /** @var ResponseInterface|ObjectProphecy */
    private $responsePrototype;

    /** @var callable */
    private $responseFactory;

    protected function setUp()
    {
        $this->request = $this->prophesize(ServerRequestInterface::class);
        $this->userRepository = $this->prophesize(UserRepositoryInterface::class);
        $this->authenticatedUser = $this->prophesize(UserInterface::class);
        $this->responsePrototype = $this->prophesize(ResponseInterface::class);
        $this->responseFactory = function () {
            return $this->responsePrototype->reveal();
        };
    }

    public function testConstructor()
    {
        $basicAccess = new BasicAccess(
            $this->userRepository->reveal(),
            'test',
            $this->responseFactory
        );
        $this->assertInstanceOf(AuthenticationInterface::class, $basicAccess);
    }

    public function testIsAuthenticatedWithoutHeader()
    {
        $this->request
            ->getHeader('Authorization')
            ->willReturn([]);

        $basicAccess = new BasicAccess(
            $this->userRepository->reveal(),
            'test',
            $this->responseFactory
        );
        $this->assertNull($basicAccess->authenticate($this->request->reveal()));
    }

    public function testIsAuthenticatedWithoutBasic()
    {
        $this->request
            ->getHeader('Authorization')
            ->willReturn(['foo']);

        $basicAccess = new BasicAccess(
            $this->userRepository->reveal(),
            'test',
            $this->responseFactory
        );

        $this->assertNull($basicAccess->authenticate($this->request->reveal()));
    }

    public function testIsAuthenticatedWithValidCredential()
    {
        $this->request
            ->getHeader('Authorization')
            ->willReturn(['Basic QWxhZGRpbjpPcGVuU2VzYW1l']);
        $this->request
            ->withAttribute(UserInterface::class, Argument::type(UserInterface::class))
            ->willReturn($this->request->reveal());

        $this->authenticatedUser
            ->getIdentity()
            ->willReturn('Aladdin');
        $this->userRepository
            ->authenticate('Aladdin', 'OpenSesame')
            ->willReturn($this->authenticatedUser->reveal());

        $basicAccess = new BasicAccess(
            $this->userRepository->reveal(),
            'test',
            $this->responseFactory
        );

        $user = $basicAccess->authenticate($this->request->reveal());
        $this->assertInstanceOf(UserInterface::class, $user);
        $this->assertEquals('Aladdin', $user->getIdentity());
    }

    public function testIsAuthenticatedWithNoCredential()
    {
        $this->request
            ->getHeader('Authorization')
            ->willReturn(['Basic QWxhZGRpbjpPcGVuU2VzYW1l']);

        $this->userRepository
            ->authenticate('Aladdin', 'OpenSesame')
            ->willReturn(null);

        $basicAccess = new BasicAccess(
            $this->userRepository->reveal(),
            'test',
            $this->responseFactory
        );

        $this->assertNull($basicAccess->authenticate($this->request->reveal()));
    }

    public function testGetUnauthenticatedResponse()
    {
        $this->responsePrototype
            ->getHeader('WWW-Authenticate')
            ->willReturn(['Basic realm="test"']);
        $this->responsePrototype
            ->withHeader('WWW-Authenticate', 'Basic realm="test"')
            ->willReturn($this->responsePrototype->reveal());
        $this->responsePrototype
            ->withStatus(401)
            ->willReturn($this->responsePrototype->reveal());

        $basicAccess = new BasicAccess(
            $this->userRepository->reveal(),
            'test',
            $this->responseFactory
        );

        $response = $basicAccess->unauthorizedResponse($this->request->reveal());

        $this->assertInstanceOf(ResponseInterface::class, $response);
        $this->assertEquals(['Basic realm="test"'], $response->getHeader('WWW-Authenticate'));
    }
}
