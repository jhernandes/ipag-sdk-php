<?php

namespace Tests;

use Ipag\Classes\Authentication;
use Ipag\Classes\Endpoint;
use Ipag\Ipag;
use PHPUnit\Framework\TestCase;

class CancelTest extends TestCase
{
    public function doCancel($identification, $tid)
    {
        $ipag = new Ipag(new Authentication($identification), Endpoint::SANDBOX);

        return $ipag->transaction()->setTid($tid)->cancel();
    }

    public function testCancelPaymentSuccessfully()
    {
        $identification = getenv('ID_IPAG');
        $paymentTest    = new PaymentTest();
        $transaction    = $paymentTest->doPayment($identification);

        $canceledTransaction = $this->doCancel($identification, $transaction->tid);

        $this->assertEquals(getenv('CANCELED'), $canceledTransaction->payment->status);
        $this->assertEquals($transaction->tid, $canceledTransaction->tid);
    }
}
