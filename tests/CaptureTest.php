<?php

namespace Tests;

use Ipag\Classes\Authentication;
use Ipag\Classes\Endpoint;
use Ipag\Ipag;
use PHPUnit\Framework\TestCase;

class CaptureTest extends TestCase
{
    public function doCapture($identification, $tid)
    {
        $ipag = new Ipag(new Authentication($identification), Endpoint::SANDBOX);

        $order = $ipag->order()
            ->setCallbackUrl(getenv('CALLBACK_URL'));

        return $ipag->transaction()->setOrder($order)->setTid($tid)->capture();
    }

    public function testCancelPaymentSuccessfully()
    {
        $identification = getenv('ID_IPAG');
        $paymentTest = new PaymentTest();
        $transaction = $paymentTest->doPayment($identification);

        $this->assertEquals(getenv('APPROVED'), $transaction->payment->status);

        $capturedTransaction = $this->doCapture($identification, $transaction->tid);

        $this->assertEquals(getenv('APPROVED_CAPTURED'), $capturedTransaction->payment->status);
        $this->assertEquals($transaction->tid, $capturedTransaction->tid);
    }
}
