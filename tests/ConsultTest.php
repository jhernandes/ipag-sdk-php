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

        $order = $ipag->order()
            ->setCallbackUrl(getenv('CALLBACK_URL'));

        return $ipag->transaction()->setOrder($order)->setTid($tid)->consult();
    }

    public function testConsultPaymentSuccessfully()
    {
        $identification = getenv('ID_IPAG');
        $paymentTest = new PaymentTest();
        $transaction = $paymentTest->doPayment($identification);

        $consultedTransaction = $this->doConsult($identification, $transaction->tid);

        $this->assertEquals(getenv('APPROVED'), $consultedTransaction->payment->status);
        $this->assertEquals($transaction->tid, $consultedTransaction->tid);
    }
}
