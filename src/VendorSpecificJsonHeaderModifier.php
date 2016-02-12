<?php

namespace Thruster\Component\HttpModifiers;

use Psr\Http\Message\ResponseInterface;
use Thruster\Component\HttpModifier\ResponseModifierInterface;

/**
 * Class VendorSpecificJsonHeaderModifier
 *
 * @package Thruster\Component\HttpModifiers
 * @author  Aurimas Niekis <aurimas@niekis.lt>
 */
class VendorSpecificJsonHeaderModifier implements ResponseModifierInterface
{
    /**
     * @var string
     */
    private $contentType;

    public function __construct(string $contentType)
    {
        $this->contentType = $contentType;
    }

    public function modify(ResponseInterface $response) : ResponseInterface
    {
        if (false === strpos($response->getHeaderLine('Content-Type'), 'application/json')) {
            return $response;
        }

        return $response->withHeader('Content-Type', $this->contentType);
    }

}
