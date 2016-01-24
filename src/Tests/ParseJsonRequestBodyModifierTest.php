<?php

namespace Thruster\Component\HttpModifiers\Tests;

use Thruster\Component\HttpModifiers\ParseJsonRequestBodyModifier;

/**
 * Class ParseJsonRequestBodyModifierTest
 *
 * @package Thruster\Component\HttpModifiers\Tests
 * @author  Aurimas Niekis <aurimas@niekis.lt>
 */
class ParseJsonRequestBodyModifierTest extends \PHPUnit_Framework_TestCase
{
    public function testModifier()
    {
        $modifier = new ParseJsonRequestBodyModifier();

        $mock = $this->getMockForAbstractClass('\Psr\Http\Message\ServerRequestInterface');
        $stream = $this->getMockForAbstractClass('\Psr\Http\Message\StreamInterface');

        $mock->expects($this->once())
            ->method('getHeaderLine')
            ->with('Content-Type')
            ->willReturn('application/json');

        $mock->expects($this->once())
            ->method('getBody')
            ->willReturn($stream);

        $stream->expects($this->once())
            ->method('getContents')
            ->willReturn(
                '{"foo":"bar"}'
            );

        $mock->expects($this->once())
            ->method('withParsedBody')
            ->with(
                [
                    'foo' => 'bar',
                ]
            )
            ->willReturnSelf();

        $modifier->modify($mock);
    }

    public function testModifierAsObject()
    {
        $modifier = new ParseJsonRequestBodyModifier(false);

        $mock = $this->getMockForAbstractClass('\Psr\Http\Message\ServerRequestInterface');
        $stream = $this->getMockForAbstractClass('\Psr\Http\Message\StreamInterface');

        $mock->expects($this->once())
            ->method('getHeaderLine')
            ->with('Content-Type')
            ->willReturn('application/json');

        $mock->expects($this->once())
            ->method('getBody')
            ->willReturn($stream);

        $stream->expects($this->once())
            ->method('getContents')
            ->willReturn(
                '{"foo":"bar"}'
            );

        $object = new \stdClass();
        $object->foo = 'bar';

        $mock->expects($this->once())
            ->method('withParsedBody')
            ->with(
                $object
            )
            ->willReturnSelf();

        $modifier->modify($mock);
    }
}
