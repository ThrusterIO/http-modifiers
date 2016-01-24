<?php

namespace Thruster\Component\HttpModifiers\Tests;

use Thruster\Component\HttpModifiers\ParseQueryParamModifier;

/**
 * Class ParseQueryParamModifierTest
 *
 * @package Thruster\Component\HttpModifiers\Tests
 * @author  Aurimas Niekis <aurimas@niekis.lt>
 */
class ParseQueryParamModifierTest extends \PHPUnit_Framework_TestCase
{
    public function testModifier()
    {
        $modifier = new ParseQueryParamModifier();

        $mock = $this->getMockForAbstractClass('\Psr\Http\Message\ServerRequestInterface');
        $uri = $this->getMockForAbstractClass('\Psr\Http\Message\UriInterface');

        $mock->expects($this->once())
            ->method('getUri')
            ->willReturn($uri);

        $uri->expects($this->once())
            ->method('getQuery')
            ->willReturn(
                'foo=bar&bar[]=foo'
            );

        $mock->expects($this->once())
            ->method('withQueryParams')
            ->with(
                [
                    'foo' => 'bar',
                    'bar' => [
                        'foo'
                    ]
                ]
            )
            ->willReturnSelf();

        $modifier->modify($mock);
    }
}
