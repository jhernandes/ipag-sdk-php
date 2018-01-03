<?php

namespace Tests\Classes;

use Ipag\Classes\Order;
use PHPUnit\Framework\TestCase;

class OrderTest extends TestCase
{
    private $order;

    public function setUp()
    {
        parent::setUp();

        $this->order = new Order;
    }

    public function testCreateAndSetOrder()
    {
        $this->order
            ->setOrderId('123456')
            ->setCallbackUrl('https://minha_loja.com.br/ipag/callback')
            ->setAmount(10.85)
            ->setInstallments(12)
            ->setExpiry('10/10/2018')
            ->setFingerPrint('ABCD123456789')
            ->setOperation(\Ipag\Classes\Enum\Operation::PAYMENT)
            ->setPayment(new \Ipag\Classes\Payment)
            ->setCustomer(new \Ipag\Classes\Customer)
            ->setCart(new \Ipag\Classes\Cart)
            ->setSubscription(new \Ipag\Classes\Subscription);

        $this->assertEquals('123456', $this->order->getOrderId());
        $this->assertEquals('https://minha_loja.com.br/ipag/callback', $this->order->getCallbackUrl());
        $this->assertEquals(10.85, $this->order->getAmount());
        $this->assertEquals(12, $this->order->getInstallments());
        $this->assertEquals('10/10/2018', $this->order->getExpiry());
        $this->assertEquals('ABCD123456789', $this->order->getFingerPrint());
        $this->assertEquals(\Ipag\Classes\Enum\Operation::PAYMENT, $this->order->getOperation());
        $this->assertInstanceOf(\Ipag\Classes\Payment::class, $this->order->getPayment());
        $this->assertInstanceOf(\Ipag\Classes\Customer::class, $this->order->getCustomer());
        $this->assertInstanceOf(\Ipag\Classes\Cart::class, $this->order->getCart());
        $this->assertInstanceOf(\Ipag\Classes\Subscription::class, $this->order->getSubscription());
    }

    public function testSetExpiryShouldThrowUnexpectedValueException()
    {
        $this->expectException(\UnexpectedValueException::class);
        $this->order->setExpiry('2018-10-10');
    }

    public function testSetInstallmentsShouldThrowUnexpectedValueException()
    {
        $this->expectException(\UnexpectedValueException::class);
        $this->order->setInstallments(48);
    }

    public function testSetInstallmentsWithNullShouldReturnOne()
    {
        $this->order->setInstallments(null);

        $this->assertEquals(1, $this->order->getInstallments());
    }
}
