<?php

namespace Tests\Classes;

use PHPUnit\Framework\TestCase;

class SubscriptionTest extends TestCase
{
    private $subscription;

    public function setUp()
    {
        parent::setUp();

        $this->subscription = new \Ipag\Classes\Subscription;
    }

    public function testCreateAndSetSubscriptionSuccessfully()
    {
        $this->subscription->setProfileId('100000')
            ->setFrequency(2)
            ->setInterval('month')
            ->setCycle(12)
            ->setAmount(39.99)
            ->setStart('10/10/2018')
            ->setTrial(false)
            ->setTrialCycle(3)
            ->setTrialFrequency(1)
            ->setTrialAmount(19.99);

        $this->assertEquals('100000', $this->subscription->getProfileId());
        $this->assertEquals(2, $this->subscription->getFrequency());
        $this->assertEquals('month', $this->subscription->getInterval());
        $this->assertEquals(12, $this->subscription->getCycle());
        $this->assertEquals(39.99, $this->subscription->getAmount());
        $this->assertEquals('10/10/2018', $this->subscription->getStart());
        $this->assertEquals(false, $this->subscription->getTrial());
        $this->assertEquals(3, $this->subscription->getTrialCycle());
        $this->assertEquals(1, $this->subscription->getTrialFrequency());
        $this->assertEquals(19.99, $this->subscription->getTrialAmount());
    }

    public function testSetFrequencyShouldThrowUnexpectedValueException()
    {
        $this->expectException(\UnexpectedValueException::class);
        $this->subscription->setFrequency(100);
    }

    public function testSetTrialFrequencyShouldThrowUnexpectedValueException()
    {
        $this->expectException(\UnexpectedValueException::class);
        $this->subscription->setTrialFrequency(100);
    }

    public function testSetIntervalShouldThrowUnexpectedValueException()
    {
        $this->expectException(\UnexpectedValueException::class);
        $this->subscription->setInterval('20');
    }

    public function testSetCycleShouldThrowUnexpectedValueException()
    {
        $this->expectException(\UnexpectedValueException::class);
        $this->subscription->setCycle(1000);
    }

    public function testSetTrialCycleShouldThrowUnexpectedValueException()
    {
        $this->expectException(\UnexpectedValueException::class);
        $this->subscription->setTrialCycle(1000);
    }

    public function testSetProfileIdShouldThrowUnexpectedValueException()
    {
        $this->expectException(\UnexpectedValueException::class);
        $this->subscription->setProfileId('ABDCD');
    }

    public function testSetStartShouldThrowUnexpectedValueException()
    {
        $this->expectException(\UnexpectedValueException::class);
        $this->subscription->setStart('2018-10-10');
    }

    public function testSetAmountShouldThrowUnexpectedValueException()
    {
        $this->expectException(\UnexpectedValueException::class);
        $this->subscription->setAmount('ABDC');
    }
}
