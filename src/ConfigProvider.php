<?php
/**
 * @see       https://github.com/zendframework/zend-expressive-authentication-basic for the canonical source repository
 * @copyright Copyright (c) 2017 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   https://github.com/zendframework/zend-expressive-authentication-basic/blob/master/LICENSE.md
 *     New BSD License
 */

namespace Zend\Expressive\Authentication\Basic;

class ConfigProvider
{
    public function __invoke() : array
    {
        return [
            'authentication' => $this->getAuthenticationConfig(),
            'dependencies' => $this->getDependencies(),
        ];
    }

    public function getAuthenticationConfig() : array
    {
        return [
            'realm' => '', // Provide the realm string
        ];
    }

    public function getDependencies() : array
    {
        return [
            'factories' => [
                BasicAccess::class => BasicAccessFactory::class,
            ],
        ];
    }
}
