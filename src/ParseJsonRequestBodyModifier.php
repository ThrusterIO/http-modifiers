<?php

namespace Thruster\Component\HttpModifiers;

use Psr\Http\Message\ServerRequestInterface;
use Thruster\Component\HttpModifier\ServerRequestModifierInterface;

/**
 * Class ParseJsonRequestBodyModifier
 *
 * @package Thruster\Component\HttpModifiers\ResponseModifier
 * @author  Aurimas Niekis <aurimas@niekis.lt>
 */
class ParseJsonRequestBodyModifier implements ServerRequestModifierInterface
{
    /**
     * @var bool
     */
    private $asAssociativeArray;

    public function __construct(bool $asAssociativeArray = true)
    {
        $this->asAssociativeArray = $asAssociativeArray;
    }

    public function modify(ServerRequestInterface $request) : ServerRequestInterface
    {
        if (false === strpos($request->getHeaderLine('Content-Type'), 'application/json')) {
            return $request;
        }

        // TODO: Implement broken json handling

        return $request->withParsedBody(json_decode($request->getBody()->getContents(), $this->asAssociativeArray));
    }

}
