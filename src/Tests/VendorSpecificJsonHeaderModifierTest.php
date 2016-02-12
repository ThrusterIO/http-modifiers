<?php

namespace Thruster\Component\HttpModifiers\Tests;

use Thruster\Component\HttpMessage\Response;
use Thruster\Component\HttpModifiers\VendorSpecificJsonHeaderModifier;

/**
 * Class VendorSpecificJsonHeaderModifierTest
 *
 * @package Thruster\Component\HttpModifiers\Tests
 * @author  Aurimas Niekis <aurimas@niekis.lt>
 */
class VendorSpecificJsonHeaderModifierTest extends \PHPUnit_Framework_TestCase
{

    public function testModifier()
    {
        $response = new Response(200, ['Content-Type' => ['application/json']]);

        $expected = 'foo/bar';

        $modifier = new VendorSpecificJsonHeaderModifier($expected);
        $response = $modifier->modify($response);

        $this->assertSame($expected, $response->getHeaderLine('Content-Type'));
    }
    
    public function testModifierNotMatched()
    {
        $expected = 'foo/bar';
        $response = new Response(200, ['Content-Type' => [$expected]]);


        $modifier = new VendorSpecificJsonHeaderModifier('bar/foo');
        $response = $modifier->modify($response);

        $this->assertSame($expected, $response->getHeaderLine('Content-Type'));
    }
}
