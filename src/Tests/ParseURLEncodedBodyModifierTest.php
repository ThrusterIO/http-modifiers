<?php

namespace Thruster\Component\HttpModifiers\Tests;

use Thruster\Component\HttpModifiers\ParseURLEncodedBodyModifier;

/**
 * Class ParseURLEncodedBodyModifierTest
 *
 * @package Thruster\Component\HttpModifiers\Tests
 * @author  Aurimas Niekis <aurimas@niekis.lt>
 */
class ParseURLEncodedBodyModifierTest extends \PHPUnit_Framework_TestCase
{
    public function testModifier()
    {
        $modifier = new ParseURLEncodedBodyModifier();

        $mock = $this->getMockForAbstractClass('\Psr\Http\Message\ServerRequestInterface');
        $stream = $this->getMockForAbstractClass('\Psr\Http\Message\StreamInterface');

        $mock->expects($this->once())
            ->method('getHeaderLine')
            ->with('Content-Type')
            ->willReturn('application/x-www-form-urlencoded');

        $mock->expects($this->once())
            ->method('getBody')
            ->willReturn($stream);

        $stream->expects($this->once())
            ->method('getContents')
            ->willReturn(
                'foo=bar&bar[]=foo'
            );

        $mock->expects($this->once())
            ->method('withParsedBody')
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
