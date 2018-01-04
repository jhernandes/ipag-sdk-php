<?php

namespace Tests;

use Ipag\Classes\Authentication;
use Ipag\Classes\Endpoint;
use Ipag\Ipag;
use PHPUnit\Framework\TestCase;

class IpagTest extends TestCase
{
    public function testCreateAndSetAuthentication()
    {
        $ipag = new Ipag(new Authentication('test@test.com'), Endpoint::SANDBOX);

        $this->assertEquals('test@test.com', $ipag->getAuthentication()->getIdentification());

        $ipag->setAuthentication(new Authentication('app@test.com'));

        $this->assertEquals('app@test.com', $ipag->getAuthentication()->getIdentification());
    }

    public function testSetEndpointAfterCreate()
    {
        $ipag = new Ipag(new Authentication('test@test.com'), Endpoint::SANDBOX);

        $this->assertEquals(Endpoint::SANDBOX, $ipag->getEndpoint()->getUrl());

        $ipag->setEndpoint(new Endpoint(Endpoint::PRODUCTION));

        $this->assertEquals(Endpoint::PRODUCTION, $ipag->getEndpoint()->getUrl());
    }
}
