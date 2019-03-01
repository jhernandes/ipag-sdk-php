<?php

namespace Tests\Classes\Http;

use Ipag\Classes\Http\CurlOnlyPostHttpClient;
use PHPUnit\Framework\TestCase;

class CurlOnlyPostHttpClientTest extends TestCase
{
    public function testCallInvokeShouldThrowException()
    {
        $this->expectException(\Exception::class);

        $onlyPost = new CurlOnlyPostHttpClient();

        $onlyPost('', [], []);
    }

    public function testCallInvokeSuccessfully()
    {
        $onlyPost = new CurlOnlyPostHttpClient();

        $response = $onlyPost(\Ipag\Classes\Endpoint::SANDBOX, [
            'Content-Type' => 'application/xml',
            'Accept'       => 'application/xml',
        ], [
            'id'   => 1,
            'name' => 'teste',
        ]);

        $this->assertNotEmpty($response);
    }
}
