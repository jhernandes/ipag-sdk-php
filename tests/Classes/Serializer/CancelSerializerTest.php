<?php

namespace Tests\Classes\Services;

use Ipag\Classes\Authentication;
use Ipag\Classes\Serializer\CancelSerializer;
use Ipag\Ipag;
use PHPUnit\Framework\TestCase;

class CancelSerializerTest extends TestCase
{
    public function testSerialize()
    {
        $ipag = new Ipag(new Authentication('app@test.com'));

        $transaction = $ipag->transaction()->setTid('123456789');

        $cancelSerializer = new CancelSerializer($transaction);

        $response = $cancelSerializer->serialize();

        $expected = [
            'identificacao' => urlencode('app@test.com'),
            'transId'       => urlencode('123456789'),
            'retorno_tipo'  => urlencode('xml'),
        ];

        $this->assertEquals($expected, $response);
    }
}
