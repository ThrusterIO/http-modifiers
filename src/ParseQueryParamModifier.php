<?php

namespace Thruster\Component\HttpModifiers;

use Psr\Http\Message\ServerRequestInterface;
use Thruster\Component\HttpModifier\ServerRequestModifierInterface;

/**
 * Class ParseQueryParamModifier
 *
 * @package Thruster\Component\HttpModifiers\ResponseModifier
 * @author  Aurimas Niekis <aurimas@niekis.lt>
 */
class ParseQueryParamModifier implements ServerRequestModifierInterface
{
    public function modify(ServerRequestInterface $request) : ServerRequestInterface
    {
        parse_str($request->getUri()->getQuery(), $queryParams);

        return $request->withQueryParams($queryParams);
    }

}
