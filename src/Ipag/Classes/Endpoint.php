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
        $this->endpoint = ($endpoint == null) ? self::PRODUCTION : $endpoint;
    }

    /**
     * @return string
     */
    public function payment()
    {
        return $this->endpoint.self::PAYMENT;
    }

    /**
     * @return string
     */
    public function consult()
    {
        return $this->endpoint.self::CONSULT;
    }

    /**
     * @return string
     */
    public function capture()
    {
        return $this->endpoint.self::CAPTURE;
    }

    /**
     * @return string
     */
    public function cancel()
    {
        return $this->endpoint.self::CANCEL;
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
