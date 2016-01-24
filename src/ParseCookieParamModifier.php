<?php

namespace Thruster\Component\HttpModifiers;

use Psr\Http\Message\ServerRequestInterface;
use Thruster\Component\HttpModifier\ServerRequestModifierInterface;

/**
 * Class ParseCookieParamModifier
 *
 * @package Thruster\Component\HttpModifiers\ResponseModifier
 * @author  Aurimas Niekis <aurimas@niekis.lt>
 */
class ParseCookieParamModifier implements ServerRequestModifierInterface
{
    public function modify(ServerRequestInterface $request) : ServerRequestInterface
    {
        $headerValues = $request->getHeader('Cookie');
        $cookies = [];

        foreach ($headerValues as $headerValue) {
            $parts = explode(';', str_replace('; ', ';', $headerValue));

            foreach ($parts as $part) {
                list($key, $value) = explode('=', $part);

                $cookies[$key] = $value;
            }
        }

        return $request->withCookieParams($cookies);
    }

}
