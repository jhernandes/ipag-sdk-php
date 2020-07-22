<?php

namespace Ipag\Classes\Services;

final class XmlService
{
    public function validate($message)
    {
        libxml_use_internal_errors(true);
        $response = simplexml_load_string($message, 'SimpleXMLElement', LIBXML_NOCDATA);

        if ($response === false) {
            $unvalidatedMessage = is_string($message) ? $message : '';
            throw new \Exception('Não foi possível identificar o XML de retorno.'.$unvalidatedMessage);
        }

        return $response;
    }

    public function xmlToStdClass($xml)
    {
        return json_decode(json_encode((array) $xml));
    }
}
