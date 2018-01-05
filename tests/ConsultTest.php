<?php

namespace Tests;

use Ipag\Classes\Authentication;
use Ipag\Classes\Endpoint;
use Ipag\Ipag;
use PHPUnit\Framework\TestCase;

class ConsultTest extends TestCase
{
    public function doConsult($tid)
    {
        $ipag = new Ipag(new Authentication(getenv('ID_IPAG'), getenv('API_KEY')), Endpoint::SANDBOX);

        return $ipag->transaction()->setTid($tid)->consult();
    }

    public function testConsultPaymentSuccessfully()
    {
        $paymentTest = new PaymentTest();
        $transaction = $paymentTest->doPayment();

        $consultedTransaction = $this->doConsult($transaction->tid);

        $this->assertEquals(getenv('APPROVED'), $consultedTransaction->payment->status);
        $this->assertEquals($transaction->tid, $consultedTransaction->tid);
    }
}
