<?php

namespace Thruster\Component\HttpModifiers\Tests;

use Thruster\Component\HttpModifiers\AddServerTimeModifier;

/**
 * Class AddServerTimeModifierTest
 *
 * @package Thruster\Component\HttpModifiers\Tests
 * @author  Aurimas Niekis <aurimas@niekis.lt>
 */
class AddServerTimeModifierTest extends \PHPUnit_Framework_TestCase
{
    public function testModifier()
    {
        $modifier = new AddServerTimeModifier();

        $mock = $this->getMockForAbstractClass('\Psr\Http\Message\ResponseInterface');

        $mock->expects($this->once())
            ->method('withHeader')
            ->will(
                $this->returnCallback(
                    function ($name, $value) use ($mock) {
                        $this->assertSame('Date', $name);
                        $this->assertLessThanOrEqual(time() + 5, strtotime($value));

                        return $mock;
                    }
                )
            );

        $modifier->modify($mock);
    }
}
