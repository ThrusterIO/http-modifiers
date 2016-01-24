<?php

namespace Thruster\Component\HttpModifiers\Tests;

use Thruster\Component\HttpModifiers\AddServerPoweredByModifier;

/**
 * Class AddServerPoweredByModifierTest
 *
 * @package Thruster\Component\HttpModifiers\Tests
 * @author  Aurimas Niekis <aurimas@niekis.lt>
 */
class AddServerPoweredByModifierTest extends \PHPUnit_Framework_TestCase
{
    public function testModifier()
    {
        $modifier = new AddServerPoweredByModifier('foo_bar');

        $mock = $this->getMockForAbstractClass('\Psr\Http\Message\ResponseInterface');

        $mock->expects($this->once())
            ->method('withHeader')
            ->will(
                $this->returnCallback(
                    function ($name, $value) use ($mock) {
                        $this->assertSame('X-Powered-By', $name);
                        $this->assertSame('foo_bar', $value);

                        return $mock;
                    }
                )
            );

        $modifier->modify($mock);
    }
}
