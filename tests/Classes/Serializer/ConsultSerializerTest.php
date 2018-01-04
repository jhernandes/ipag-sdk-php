<?php

namespace Tests\Classes\Services;

use Ipag\Classes\Authentication;
use Ipag\Classes\Serializer\ConsultSerializer;
use Ipag\Ipag;
use PHPUnit\Framework\TestCase;

class ConsultSerializerTest extends TestCase
{
    public function testSerialize()
    {
        $ipag = new Ipag(new Authentication('app@test.com'));

        $transaction = $ipag->transaction()->setTid('123456789');

        $consultSerializer = new ConsultSerializer($transaction);

        $response = $consultSerializer->serialize();

        $expected = [
            'identificacao' => urlencode('app@test.com'),
            'transId'       => urlencode('123456789'),
            'retorno_tipo'  => urlencode('xml'),
        ];

        $this->assertEquals($expected, $response);
    }
}
