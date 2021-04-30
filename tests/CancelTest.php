<?php

namespace Tests;

use Ipag\Classes\Authentication;
use Ipag\Classes\Endpoint;
use Ipag\Classes\Enum\PaymentStatus;
use Ipag\Ipag;
use PHPUnit\Framework\TestCase;

class CancelTest extends TestCase
{
    private $ipag;

    public function setUp()
    {
        $this->ipag = new Ipag(new Authentication(getenv('ID_IPAG'), getenv('API_KEY')), Endpoint::SANDBOX);
    }

    public function doCancel($tid)
    {
        return $this->ipag->transaction()->setTid($tid)->cancel();
    }

    public function testCancelPaymentSuccessfully()
    {
        $paymentTest = new PaymentTest();
        $transaction = $paymentTest->doPayment();

        $canceledTransaction = $this->doCancel($transaction->tid);

        $this->assertEquals(PaymentStatus::CANCELED, $canceledTransaction->payment->status);
        $this->assertEquals($transaction->tid, $canceledTransaction->tid);
    }

    public function testCancelPartialPaymentSuccessfully()
    {
        $paymentTest = new PaymentTest();
        $transaction = $paymentTest->doPayment();

        $canceledTransaction = $this->ipag
            ->transaction()
            ->setTid($transaction->tid)
            ->setAmount('5.00')
            ->cancel();

        $this->assertEquals(PaymentStatus::PRE_AUTHORIZED, $canceledTransaction->payment->status);
        $this->assertEquals($transaction->tid, $canceledTransaction->tid);
        $this->assertEquals('voided', $canceledTransaction->history[2]->operationType);
        $this->assertEquals('succeeded', $canceledTransaction->history[2]->status);
        $this->assertEquals('5.00', $canceledTransaction->history[2]->amount);
    }
}
