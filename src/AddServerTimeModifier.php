<?php

namespace Thruster\Component\HttpModifiers;

use Psr\Http\Message\ResponseInterface;
use Thruster\Component\HttpModifier\ResponseModifierInterface;

/**
 * Class AddServerTimeModifier
 *
 * @package Thruster\Component\HttpModifiers
 * @author  Aurimas Niekis <aurimas@niekis.lt>
 */
class AddServerTimeModifier implements ResponseModifierInterface
{
    public function modify(ResponseInterface $response) : ResponseInterface
    {
        return $response->withHeader('Date', gmdate('D, d M Y H:i:s T'));
    }
}
