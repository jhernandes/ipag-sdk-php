<?php

namespace Tests\Classes;

use Ipag\Classes\Endpoint;
use PHPUnit\Framework\TestCase;

class EndpointTest extends TestCase
{
    public function testCreateAndSetEndpoint()
    {
        $endpoint = new Endpoint(Endpoint::SANDBOX);

        $this->assertEquals($endpoint->getEndpoint(), Endpoint::SANDBOX);

        $endpoint->setEndpoint(Endpoint::PRODUCTION);

        $this->assertEquals($endpoint->getEndpoint(), Endpoint::PRODUCTION);
    }

    public function testGetPaymentEndpointUrl()
    {
        $endpoint = new Endpoint(Endpoint::SANDBOX);

        $this->assertEquals($endpoint->payment(), Endpoint::SANDBOX . Endpoint::PAYMENT);
    }

    public function testGetConsultEndpointUrl()
    {
        $endpoint = new Endpoint(Endpoint::SANDBOX);

        $this->assertEquals($endpoint->consult(), Endpoint::SANDBOX . Endpoint::CONSULT);
    }

    public function testGetCancelEndpointUrl()
    {
        $endpoint = new Endpoint(Endpoint::SANDBOX);

        $this->assertEquals($endpoint->cancel(), Endpoint::SANDBOX . Endpoint::CANCEL);
    }

    public function testGetCaptureEndpointUrl()
    {
        $endpoint = new Endpoint(Endpoint::SANDBOX);

        $this->assertEquals($endpoint->CAPTURE(), Endpoint::SANDBOX . Endpoint::CAPTURE);
    }
}
