<?php

namespace Ipag\Classes\Services;

final class XmlService
{
    public function validate($message)
    {
        libxml_use_internal_errors(true);
        $response = simplexml_load_string($message, 'SimpleXMLElement', LIBXML_NOCDATA);

        if ($response === false) {
            return false;
        }

        return $response;
    }
}
