<?php

namespace Tests;

use Ipag\Classes\Authentication;
use Ipag\Classes\Endpoint;
use Ipag\Ipag;
use PHPUnit\Framework\TestCase;

class CaptureTest extends TestCase
{
    private $ipag;

    public function setUp()
    {
        $this->ipag = new Ipag(new Authentication(getenv('ID_IPAG'), getenv('API_KEY')), Endpoint::SANDBOX);
    }

    public function doCapture($tid)
    {
        return $this->ipag->transaction()->setTid($tid)->capture();
    }

    public function testCapturePaymentSuccessfully()
    {
        $paymentTest = new PaymentTest();
        $transaction = $paymentTest->doPayment();

        $this->assertEquals(getenv('APPROVED'), $transaction->payment->status);

        $capturedTransaction = $this->doCapture($transaction->tid);

        $this->assertEquals(getenv('APPROVED_CAPTURED'), $capturedTransaction->payment->status);
        $this->assertEquals($transaction->tid, $capturedTransaction->tid);
    }

    public function testCapturePartialPaymentSuccessfully()
    {
        $paymentTest = new PaymentTest();
        $transaction = $paymentTest->doPayment();

        $canceledTransaction = $this->ipag
            ->transaction()
            ->setTid($transaction->tid)
            ->setAmount('5.00')
            ->capture();

        $this->assertEquals(getenv('APPROVED_CAPTURED'), $canceledTransaction->payment->status);
        $this->assertEquals($transaction->tid, $canceledTransaction->tid);
        $this->assertEquals('captured', $canceledTransaction->history[2]->operationType);
        $this->assertEquals('succeeded', $canceledTransaction->history[2]->status);
        $this->assertEquals('5.00', $canceledTransaction->history[2]->amount);
    }
}
