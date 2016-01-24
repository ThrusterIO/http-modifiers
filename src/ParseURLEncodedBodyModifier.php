<?php

namespace Thruster\Component\HttpModifiers;

use Psr\Http\Message\ServerRequestInterface;
use Thruster\Component\HttpModifier\ServerRequestModifierInterface;

/**
 * Class ParseURLEncodedBodyModifier
 *
 * @package Thruster\Component\HttpModifiers\ResponseModifier
 * @author  Aurimas Niekis <aurimas@niekis.lt>
 */
class ParseURLEncodedBodyModifier implements ServerRequestModifierInterface
{
    public function modify(ServerRequestInterface $request) : ServerRequestInterface
    {
        if (false === strpos($request->getHeaderLine('Content-Type'), 'application/x-www-form-urlencoded')) {
            return $request;
        }

        parse_str($request->getBody()->getContents(), $parsedBody);

        return $request->withParsedBody($parsedBody);
    }

}
