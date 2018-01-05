<?php

namespace Tests;

use Ipag\Classes\Authentication;
use Ipag\Classes\Endpoint;
use Ipag\Ipag;
use PHPUnit\Framework\TestCase;

class CancelTest extends TestCase
{
    public function doCancel($tid)
    {
        $ipag = new Ipag(new Authentication(getenv('ID_IPAG'), getenv('API_KEY')), Endpoint::SANDBOX);

        return $ipag->transaction()->setTid($tid)->cancel();
    }

    public function testCancelPaymentSuccessfully()
    {
        $paymentTest = new PaymentTest();
        $transaction = $paymentTest->doPayment();

        $canceledTransaction = $this->doCancel($transaction->tid);

        $this->assertEquals(getenv('CANCELED'), $canceledTransaction->payment->status);
        $this->assertEquals($transaction->tid, $canceledTransaction->tid);
    }
}
