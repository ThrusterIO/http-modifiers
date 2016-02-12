<?php

namespace Thruster\Component\HttpModifiers;

use Psr\Http\Message\ServerRequestInterface;
use Thruster\Component\HttpMessage\UploadedFile;
use Thruster\Component\HttpModifier\ServerRequestModifierInterface;

/**
 * Class ParseMultiPartBodyModifier
 *
 * @package Thruster\Component\HttpModifiers
 * @author  Aurimas Niekis <aurimas@niekis.lt>
 */
class ParseMultiPartBodyModifier implements ServerRequestModifierInterface
{
    public function modify(ServerRequestInterface $request) : ServerRequestInterface
    {
        $headerLine = $request->getHeaderLine('Content-Type');

        if (false === strpos($headerLine, 'multipart/')) {
            return $request;
        }

        $boundary = null;
        if (preg_match("/boundary=\"?(.*)\"?$/", $headerLine, $matches)) {
            $boundary = $matches[1];
        }

        $variables = [];
        $files     = [];

        $body     = $request->getBody()->detach();
        $partInfo = null;

        while (false !== ($lineN = fgets($body))) {
            if (0 === strpos($lineN, '--')) {
                if (null === $boundary) {
                    $boundary = rtrim($lineN);
                }

                continue;
            }

            $line = rtrim($lineN);

            if ('' === $line) {
                if (isset($partInfo['Content-Disposition']) &&
                    true !== empty($partInfo['Content-Disposition']['filename'])
                ) {
                    $this->parseFile($body, $boundary, $partInfo, $files);
                } elseif ($partInfo !== null) {
                    $this->parseVariable($body, $boundary, $partInfo['Content-Disposition']['name'], $variables);
                }

                $partInfo = null;
                continue;
            }

            list($key, $value) = explode(':', $line, 2);

            $partInfo[$key] = $this->parseHeader($value, $key);
        }

        return $request
            ->withParsedBody($variables)
            ->withUploadedFiles($files);
    }

    private function parseFile($body, $boundary, $partInfo, &$files)
    {
        $tempDir = sys_get_temp_dir();

        $name        = $partInfo['Content-Disposition']['name'];
        $fileName    = $partInfo['Content-Disposition']['filename'] ?? null;
        $contentType = $partInfo['Content-Type']['value'] ?? null;

        if (empty($tempDir)) {
            $errorCode = UPLOAD_ERR_NO_TMP_DIR;

            $files[$name] = new UploadedFile(null, 0, $errorCode, $fileName, $contentType);

            return;
        }

        $tempName = tempnam($tempDir, 'thruster_file_upload');
        $stream   = fopen($tempName, 'wb');

        if (false === $stream) {
            $errorCode = UPLOAD_ERR_CANT_WRITE;

            $files[$name] = new UploadedFile(null, 0, $errorCode, $fileName, $contentType);

            return;
        }

        $lastLine = null;
        while (false !== ($lineN = fgets($body, 4096))) {
            if ($lastLine !== null) {
                if (false !== strpos($lineN, $boundary)) {
                    break;
                }

                if (false === fwrite($stream, $lastLine)) {
                    $errorCode = UPLOAD_ERR_CANT_WRITE;

                    $files[$name] = new UploadedFile(null, 0, $errorCode, $fileName, $contentType);
                    fclose($stream);
                    unlink($tempName);

                    return;
                }

            }

            $lastLine = $lineN;
        }

        if (null !== $lastLine) {
            if (false === fwrite($stream, rtrim($lastLine, "\r\n"))) {
                $errorCode = UPLOAD_ERR_CANT_WRITE;

                $files[$name] = new UploadedFile(null, 0, $errorCode, $fileName, $contentType);
                fclose($stream);
                unlink($tempName);

                return;
            }
        }

        fclose($stream);

        $files[$name] = new UploadedFile(
            $tempName,
            filesize($tempName),
            UPLOAD_ERR_OK,
            $fileName,
            $contentType
        );
    }

    private function parseVariable($body, $boundary, $name, &$variables)
    {
        $fullValue = '';
        $lastLine = null;

        while (false !== ($lineN = fgets($body)) && false === strpos($lineN, $boundary)) {
            if (null !== $lastLine) {
                $fullValue .= $lastLine;
            }

            $lastLine = $lineN;
        }

        if (null !== $lastLine) {
            $fullValue .= rtrim($lastLine, "\r\n");
        }

        $variables[$name] = $fullValue;
    }

    private function parseHeader($value, $key = '')
    {
        $result = [];

        $regex = '/(^|;)\s*(?P<name>[^=:,;\s"]*):?(=("(?P<quotedValue>' .
            '[^"]*(\\.[^"]*)*)")|(\s*(?P<value>[^=,;\s"]*)))?/mx';

        preg_match_all($regex, $value, $matches, PREG_SET_ORDER);

        foreach ($matches as $index => $match) {
            $name        = $match['name'];
            $quotedValue = $match['quotedValue'];

            if (empty($quotedValue)) {
                $value = $match['value'];
            } else {
                $value = stripcslashes($quotedValue);
            }

            if ($name == $key && 0 === $index) {
                $name = 'value';
            }

            $result[$name] = $value;
        }

        return $result;
    }
}
