<?php

namespace Tests\Classes\Services;

use Ipag\Classes\Authentication;
use Ipag\Classes\Order;
use Ipag\Classes\Serializer\CaptureSerializer;
use Ipag\Classes\Transaction;
use Ipag\Ipag;
use PHPUnit\Framework\TestCase;

class CaptureSerializerTest extends TestCase
{
    public function testSerialize()
    {
        $transaction = new Transaction(new Ipag(new Authentication('app@test.com')));
        $order = new Order;
        $order->setCallbackUrl('https://minha_loja.com.br/ipag/callback');
        $transaction->setOrder($order)->setTid('123456789');

        $captureSerializer = new CaptureSerializer($transaction);

        $response = $captureSerializer->serialize();

        $expected = array(
            'identificacao' => urlencode('app@test.com'),
            'transId' => urlencode('123456789'),
            'url_retorno' => urlencode('https://minha_loja.com.br/ipag/callback'),
            'retorno_tipo' => urlencode('xml'),
        );

        $this->assertEquals($expected, $response);
    }
}
