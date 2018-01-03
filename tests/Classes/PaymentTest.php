<?php

namespace Tests\Classes;

use PHPUnit\Framework\TestCase;

class PaymentTest extends TestCase
{
    public function testCreateAndSetPayment()
    {
        $payment = new \Ipag\Classes\Payment;
        $payment
            ->setMethod(\Ipag\Classes\Enum\Method::VISA)
            ->setSoftDescriptor('EMPRESA')
            ->setInstructions('Instrução 1')
            ->setInstructions('Instrução 2')
            ->setInstructions('Instrução 3')
            ->setInstructions('Instrução 4')
            ->setCreditCard(new \Ipag\Classes\CreditCard);

        $this->assertEquals(\Ipag\Classes\Enum\Method::VISA, $payment->getMethod());
        $this->assertEquals('EMPRESA', $payment->getSoftDescriptor());
        $this->assertEquals(3, count($payment->getInstructions()));
        $this->assertInstanceOf(\Ipag\Classes\CreditCard::class, $payment->getCreditCard());
    }

}
