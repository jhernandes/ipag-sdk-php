<?php

namespace Tests;

use Ipag\Classes\Authentication;
use Ipag\Classes\Endpoint;
use Ipag\Ipag;
use PHPUnit\Framework\TestCase;

class CaptureTest extends TestCase
{
    public function doCapture($tid)
    {
        $ipag = new Ipag(new Authentication(getenv('ID_IPAG'), getenv('API_KEY')), Endpoint::SANDBOX);

        return $ipag->transaction()->setTid($tid)->capture();
    }

    public function testCancelPaymentSuccessfully()
    {
        $paymentTest = new PaymentTest();
        $transaction = $paymentTest->doPayment();

        $this->assertEquals(getenv('APPROVED'), $transaction->payment->status);

        $capturedTransaction = $this->doCapture($transaction->tid);

        $this->assertEquals(getenv('APPROVED_CAPTURED'), $capturedTransaction->payment->status);
        $this->assertEquals($transaction->tid, $capturedTransaction->tid);
    }
}
