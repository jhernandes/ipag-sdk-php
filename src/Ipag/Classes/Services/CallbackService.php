<?php

namespace Ipag\Classes\Services;

final class CallbackService
{
    public function getResponse($message)
    {
        $xmlService = new XmlService();

        $simpleXmlObject = $xmlService->validate($message);

        $response = $xmlService->xmlToStdClass($simpleXmlObject);

        return (new TransactionResponseService())->populate($response);
    }
}
