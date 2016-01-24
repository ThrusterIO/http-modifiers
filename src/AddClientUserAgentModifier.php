<?php

namespace Thruster\Component\HttpModifiers;

use Psr\Http\Message\RequestInterface;
use Thruster\Component\HttpModifier\RequestModifierInterface;

/**
 * Class AddClientUserAgentModifier
 *
 * @package Thruster\Component\HttpModifiers\ResponseModifier
 * @author  Aurimas Niekis <aurimas@niekis.lt>
 */
class AddClientUserAgentModifier implements RequestModifierInterface
{
    /**
     * @var string
     */
    private $userAgent;

    public function __construct(string $userAgent)
    {
        $this->userAgent = $userAgent;
    }

    public function modify(RequestInterface $response) : RequestInterface
    {
        return $response->withHeader('User-Agent', $this->userAgent);
    }
}
