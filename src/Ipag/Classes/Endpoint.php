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
    private $url;

    public function __construct($url = self::PRODUCTION)
    {
        $this->url = $url;
    }

    /**
     * @return string
     */
    public function payment()
    {
        return $this->url.self::PAYMENT;
    }

    /**
     * @return string
     */
    public function consult()
    {
        return $this->url.self::CONSULT;
    }

    /**
     * @return string
     */
    public function capture()
    {
        return $this->url.self::CAPTURE;
    }

    /**
     * @return string
     */
    public function cancel()
    {
        return $this->url.self::CANCEL;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param string $url
     *
     * @return self
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }
}
