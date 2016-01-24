<?php

namespace Thruster\Component\HttpModifiers\Tests;

use Thruster\Component\HttpModifiers\ParseCookieParamModifier;

/**
 * Class ParseCookieParamModifierTest
 *
 * @package Thruster\Component\HttpModifiers\Tests
 * @author  Aurimas Niekis <aurimas@niekis.lt>
 */
class ParseCookieParamModifierTest extends \PHPUnit_Framework_TestCase
{
    public function testModifier()
    {
        $modifier = new ParseCookieParamModifier();

        $mock = $this->getMockForAbstractClass('\Psr\Http\Message\ServerRequestInterface');

        $mock->expects($this->once())
            ->method('getHeader')
            ->will(
                $this->returnCallback(
                    function ($name) {
                        $this->assertSame('Cookie', $name);

                        return ['foo=bar;bar=foo', 'oof=rab;rab=oof'];
                    }
                )
            );

        $mock->expects($this->once())
            ->method('withCookieParams')
            ->with(
                [
                    'foo' => 'bar',
                    'bar' => 'foo',
                    'oof' => 'rab',
                    'rab' => 'oof'
                ]
            )
            ->willReturnSelf();

        $modifier->modify($mock);
    }
}
