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

    public function testCustomerReturnFields()
    {
        $paymentTest = new PaymentTest();
        $transaction = $paymentTest->doPayment();

        $consultedTransaction = $this->doConsult($transaction->tid);

        $this->assertNotEmpty($consultedTransaction->id);
        $this->assertNotEmpty($consultedTransaction->urlCallback);
        $this->assertNotEmpty($consultedTransaction->createAt);
        $this->assertEquals($consultedTransaction->customer->name, "Fulano da Silva");
        $this->assertEquals($consultedTransaction->customer->email, 'fulanodasilva@gmail.com');
        $this->assertEquals($consultedTransaction->customer->phone, "11988883333");
        $this->assertEquals($consultedTransaction->customer->address->street, 'RUA JULIO GONZALEZ');
        $this->assertEquals($consultedTransaction->customer->address->number, '1000');
        $this->assertEquals($consultedTransaction->customer->address->complement, '');
        $this->assertEquals($consultedTransaction->customer->address->district, 'BARRA FUNDA');
        $this->assertEquals($consultedTransaction->customer->address->city, 'SAO PAULO');
        $this->assertEquals($consultedTransaction->customer->address->state, 'SP');
        $this->assertEquals($consultedTransaction->customer->address->zipCode, '01156060');
    }

    public function testHistoryReturnFields()
    {
        $paymentTest = new PaymentTest();
        $transaction = $paymentTest->doPayment();

        $consultedTransaction = $this->doConsult($transaction->tid);

        $this->assertNotEmpty($consultedTransaction->history);
        $this->assertEquals($consultedTransaction->history[0]->amount, '10.00');
        $this->assertEquals($consultedTransaction->history[0]->operationType, 'created');
        $this->assertEquals($consultedTransaction->history[0]->status, 'succeeded');
        $this->assertEquals($consultedTransaction->history[1]->amount, '10.00');
        $this->assertEquals($consultedTransaction->history[1]->operationType, 'authorized');
        $this->assertEquals($consultedTransaction->history[1]->status, 'succeeded');
        $this->assertEquals($consultedTransaction->history[1]->responseMessage, 'pre_authorized');
        $this->assertNotEmpty($consultedTransaction->history[1]->authorizationCode);
        $this->assertNotEmpty($consultedTransaction->history[1]->authorizationId);
        $this->assertNotEmpty($consultedTransaction->history[1]->createdAt);
    }
}
