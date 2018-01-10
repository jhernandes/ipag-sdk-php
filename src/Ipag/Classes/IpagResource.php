<?php

namespace Ipag\Classes;

use Ipag\Classes\Http\AuthenticableHttpInterface;
use Ipag\Classes\Http\CurlOnlyPostHttpClient;
use Ipag\Ipag;
use stdClass;

abstract class IpagResource extends BaseResource
{
    /**
     * @var Ipag
     */
    protected $ipag;

    /**
     * @var AuthenticableHttpInterface
     */
    protected $onlyPostClient;

    /**
     * @var Contracts\Operationable
     */
    protected $apiService;

    abstract public function populate(stdClass $response);

    public function __construct(Ipag $ipag)
    {
        $this->setOnlyPostClient(new CurlOnlyPostHttpClient());
        $this->setIpag($ipag);
    }

    /**
     * @return AuthenticableHttpInterface
     */
    public function getOnlyPostClient()
    {
        return $this->onlyPostClient;
    }

    /**
     * @param AuthenticableHttpInterface $onlyPostClient
     */
    public function setOnlyPostClient(AuthenticableHttpInterface $onlyPostClient)
    {
        $this->onlyPostClient = $onlyPostClient;

        return $this;
    }

    public function sendHttpRequest($endpoint, $parameters)
    {
        $onlyPostClient = $this->getOnlyPostClient();
        $response = $onlyPostClient(
            $endpoint,
            $this->getIpagHeaders(),
            $parameters
        );

        return $this->checkIfIsValidXmlAndReturnStdClass($response);
    }

    private function checkIfIsValidXmlAndReturnStdClass($response)
    {
        $xmlService = new Services\XmlService();

        $simpleXmlObject = $xmlService->validate($response);

        return $xmlService->xmlToStdClass($simpleXmlObject);
    }

    private function getIpagHeaders()
    {
        return [
            'Content-Type' => 'application/x-www-form-urlencoded; charset=utf-8',
            'Accept'       => 'application/xml',
        ];
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
