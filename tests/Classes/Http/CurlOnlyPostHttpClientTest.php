<?php

namespace Tests\Classes\Http;

use Ipag\Http\CurlOnlyPostHttpClient;
use PHPUnit\Framework\TestCase;

class CurlOnlyPostHttpClientTest extends TestCase
{
    public function testCallInvokeShouldThrowException()
    {
        $this->expectException(\Exception::class);

        $onlyPost = new CurlOnlyPostHttpClient();

        $onlyPost('', array(), array());
    }

    public function testCallInvokeSuccessfully()
    {
        $onlyPost = new CurlOnlyPostHttpClient();

        $response = $onlyPost(\Ipag\Classes\Endpoint::SANDBOX, array(
            'Content-Type' => 'application/xml',
            'Accept' => 'application/xml',
        ), array(
            'id' => 1,
            'name' => 'teste',
        ));

        $this->assertEquals('API IPAG - SANDBOX', $response);
    }
}
