# HttpModifier Collection of Modifiers

[![Latest Version](https://img.shields.io/github/release/ThrusterIO/http-modifiers.svg?style=flat-square)]
(https://github.com/ThrusterIO/http-modifiers/releases)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)]
(LICENSE)
[![Build Status](https://img.shields.io/travis/ThrusterIO/http-modifiers.svg?style=flat-square)]
(https://travis-ci.org/ThrusterIO/http-modifiers)
[![Code Coverage](https://img.shields.io/scrutinizer/coverage/g/ThrusterIO/http-modifiers.svg?style=flat-square)]
(https://scrutinizer-ci.com/g/ThrusterIO/http-modifiers)
[![Quality Score](https://img.shields.io/scrutinizer/g/ThrusterIO/http-modifiers.svg?style=flat-square)]
(https://scrutinizer-ci.com/g/ThrusterIO/http-modifiers)
[![Total Downloads](https://img.shields.io/packagist/dt/thruster/http-modifiers.svg?style=flat-square)]
(https://packagist.org/packages/thruster/http-modifiers)

[![Email](https://img.shields.io/badge/email-team@thruster.io-blue.svg?style=flat-square)]
(mailto:team@thruster.io)

The Thruster HttpModifier Collection of Modifiers 

## Install

Via Composer

``` bash
$ composer require thruster/http-modifiers
```

## Available Modifiers

| Name | Type | Description |
|------|------|-------------|
|AddClientUserAgentModifier|RequestModifier |Adds `User-Agent` header to RequestInterface  
|AddServerPoweredByModifier|ResponseModifier|Adds `X-Powered-By` header to Response Interface
|AddServerTimeModifier|ResponseModifier|Adds `Date` header to Response Interface with `gmdate`
|ParseCookieParamModifier|ServerRequestModifier|Parses `Cookie` header and fills `ServerRequestInterface::cookieParams`
|ParseJsonRequestBodyModifier|ServerRequestModifier|Parses json body and fills `ServerRequestInterface::parsedBody`
|ParseMultiPartBodyModifier|ServerRequestModifier|Parses multipart body and fills `ServerRequestInterface::parsedBody` and `ServerRequestInterface::uploadedFiles`
|ParseQueryParamModifier|ServerRequestModifier|Parses `getUri()->getQuery()` and fills `ServerRequestInterface::queryParams`
|ParseURLEncodedBodyModifier|ServerRequestModifier|Parses url-encoded body and fills `ServerRequestInterface::parsedBody`


## Testing

``` bash
$ composer test
```


## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CONDUCT](CONDUCT.md) for details.


## License

Please see [License File](LICENSE) for more information.
