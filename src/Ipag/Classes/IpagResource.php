<?php

namespace Ipag\Classes;

use Ipag\Http\CurlOnlyPostHttpClient;
use Ipag\Http\OnlyPostHttpClientInterface;
use Ipag\Ipag;

abstract class IpagResource
{
    /**
     * @var Ipag
     */
    protected $ipag;

    /**
     * @var OnlyPostHttpClientInterface
     */
    protected $onlyPostClient;

    abstract protected function populate(\stdClass $response);

    public function __construct(Ipag $ipag)
    {
        $this->setOnlyPostClient(new CurlOnlyPostHttpClient());
        $this->setIpag($ipag);
    }

    /**
     * @return OnlyPostHttpClientInterface
     */
    public function getOnlyPostClient()
    {
        return $this->onlyPostClient;
    }

    /**
     * @param OnlyPostHttpClientInterface $onlyPostClient
     */
    public function setOnlyPostClient(OnlyPostHttpClientInterface $onlyPostClient)
    {
        $this->onlyPostClient = $onlyPostClient;

        return $this;
    }

    protected function sendHttpRequest($endpoint, $parameters)
    {
        $onlyPostClient = $this->getOnlyPostClient();
        $xmlResponse = $onlyPostClient(
            $endpoint,
            $this->getIpagHeaders(),
            $parameters
        );

        return $this->checkIfIsValidXmlAndReturnStdClass($xmlResponse);
    }

    private function checkIfIsValidXmlAndReturnStdClass($xmlResponse)
    {
        $xmlObject = Services\XmlService::validate($xmlResponse);
        if (!$xmlObject) {
            throw new \Exception("Não foi possível identificar o XML de retorno.");
        }

        return json_decode(json_encode((array) $xmlObject));
    }

    private function getIpagHeaders()
    {
        return array(
            'Content-Type' => 'application/x-www-form-urlencoded; charset=utf-8',
            'Accept' => 'application/xml',
        );
    }

    /**
     * @return Ipag
     */
    public function getIpag()
    {
        return $this->ipag;
    }

    /**
     * @param Ipag $ipag
     */
    public function setIpag(Ipag $ipag)
    {
        $this->ipag = $ipag;

        return $this;
    }
}
