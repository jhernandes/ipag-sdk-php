<?php

namespace Ipag\Classes;

final class Endpoint
{
    const PRODUCTION = 'https://www.librepag.com.br';
    const SANDBOX = 'https://sandbox.ipag.com.br';
    const PAYMENT = '/pagamento';
    const CONSULT = '/consulta';
    const CAPTURE = '/captura';
    const CANCEL = '/cancela';

    /**
     * @var string
     */
    private $endpoint;

    public function __construct($endpoint = null)
    {
        $this->endpoint = ($endpoint == null) ? Endpoint::PRODUCTION : $endpoint;
    }

    /**
     * @return string
     */
    public function payment()
    {
        return $this->endpoint . Endpoint::PAYMENT;
    }

    /**
     * @return string
     */
    public function consult()
    {
        return $this->endpoint . Endpoint::CONSULT;
    }

    /**
     * @return string
     */
    public function capture()
    {
        return $this->endpoint . Endpoint::CAPTURE;
    }

    /**
     * @return string
     */
    public function cancel()
    {
        return $this->endpoint . Endpoint::CANCEL;
    }

    /**
     * @return string
     */
    public function getEndpoint()
    {
        return $this->endpoint;
    }

    /**
     * @param string $endpoint
     *
     * @return self
     */
    public function setEndpoint($endpoint)
    {
        $this->endpoint = $endpoint;

        return $this;
    }
}
