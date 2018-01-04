<?php

namespace Tests;

use Ipag\Classes\Authentication;
use Ipag\Classes\Endpoint;
use Ipag\Ipag;
use PHPUnit\Framework\TestCase;

class ConsultTest extends TestCase
{
    public function doConsult($identification, $tid)
    {
        $ipag = new Ipag(new Authentication($identification), Endpoint::SANDBOX);

        return $ipag->transaction()->setTid($tid)->consult();
    }

    public function testConsultPaymentSuccessfully()
    {
        $identification = getenv('ID_IPAG');
        $paymentTest = new PaymentTest();
        $transaction = $paymentTest->doPayment();

        $consultedTransaction = $this->doConsult($identification, $transaction->tid);

        $this->assertEquals(getenv('APPROVED'), $consultedTransaction->payment->status);
        $this->assertEquals($transaction->tid, $consultedTransaction->tid);
    }
}
