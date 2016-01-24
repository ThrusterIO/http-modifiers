<?php

namespace Thruster\Component\HttpModifiers;

use Psr\Http\Message\ResponseInterface;
use Thruster\Component\HttpModifier\ResponseModifierInterface;

/**
 * Class AddServerPoweredByModifier
 *
 * @package Thruster\Component\HttpModifiers
 * @author  Aurimas Niekis <aurimas@niekis.lt>
 */
class AddServerPoweredByModifier implements ResponseModifierInterface
{
    /**
     * @var string
     */
    private $poweredBy;

    public function __construct(string $poweredBy)
    {
        $this->poweredBy = $poweredBy;
    }

    public function modify(ResponseInterface $response) : ResponseInterface
    {
        return $response->withHeader('X-Powered-By', $this->poweredBy);
    }
}
