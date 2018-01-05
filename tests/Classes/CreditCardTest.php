<?php

namespace Tests\Classes;

use PHPUnit\Framework\TestCase;

class CreditCardTest extends TestCase
{
    private $card;

    public function setUp()
    {
        parent::setUp();

        $this->card = new \Ipag\Classes\CreditCard();
    }

    public function testCreateAndSetCreditCardSuccessfully()
    {
        $this->card->setNumber('4111 1111 1111 1111')
            ->setToken('ABDCD123456789')
            ->setHolder('FULANO DA SILVA')
            ->setExpiryMonth('05')
            ->setExpiryYear('2022')
            ->setCvc('123')
            ->setSave(false);

        $this->assertEquals($this->card->getToken(), 'ABDCD123456789');
        $this->assertEquals($this->card->getNumber(), '4111111111111111');
        $this->assertEquals($this->card->getHolder(), 'FULANO DA SILVA');
        $this->assertEquals($this->card->getExpiryMonth(), '05');
        $this->assertEquals($this->card->getExpiryYear(), '2022');
        $this->assertEquals($this->card->getCvc(), '123');
        $this->assertEquals($this->card->hasSave(), false);
    }

    public function testSetExpiryMonthThrowUnexpectedValueException()
    {
        $this->expectException(\UnexpectedValueException::class);
        $this->card->setExpiryMonth('100');
    }

    public function testSetExpiryYearThrowUnexpectedValueException()
    {
        $this->expectException(\UnexpectedValueException::class);
        $this->card->setExpiryYear('1');
    }

    public function testSetCvcShouldThrowUnexpectedValueException()
    {
        $this->expectException(\UnexpectedValueException::class);
        $this->card->setCvc('ABCD');
    }

    public function testIfCreditCardHasToken()
    {
        $this->card->setToken(null);
        $this->assertFalse($this->card->hasToken());

        $this->card->setToken('ABCD123456789');
        $this->assertTrue($this->card->hasToken());
    }

    public function testIfCreditCardHasCvc()
    {
        $this->card = new \Ipag\Classes\CreditCard();
        $this->assertFalse($this->card->hasCvc());

        $this->card->setCvc('123');
        $this->assertTrue($this->card->hasCvc());
    }

    public function testHideSensitiveCreditCardData()
    {
        $this->card->setNumber('4111 1111 1111 1111')
            ->setCvc('123');

        $this->card->hide();

        $this->assertEquals($this->card->getNumber(), '411111******1111');
        $this->assertEquals($this->card->getCvc(), '***');
    }
}
