<?php

namespace Thruster\Component\HttpModifiers\Tests;

use Thruster\Component\HttpModifiers\AddClientUserAgentModifier;

/**
 * Class AddClientUserAgentModifierTest
 *
 * @package Thruster\Component\HttpModifiers\Tests
 * @author  Aurimas Niekis <aurimas@niekis.lt>
 */
class AddClientUserAgentModifierTest extends \PHPUnit_Framework_TestCase
{
    public function testModifier()
    {
        $modifier = new AddClientUserAgentModifier('foo_bar');

        $mock = $this->getMockForAbstractClass('\Psr\Http\Message\RequestInterface');

        $mock->expects($this->once())
            ->method('withHeader')
            ->will(
                $this->returnCallback(
                    function ($name, $value) use ($mock) {
                        $this->assertSame('User-Agent', $name);
                        $this->assertSame('foo_bar', $value);

                        return $mock;
                    }
                )
            );

        $modifier->modify($mock);
    }
}
