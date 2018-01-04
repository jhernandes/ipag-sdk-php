<?php

namespace Tests;

use Ipag\Classes\Authentication;
use Ipag\Classes\Endpoint;
use Ipag\Classes\Enum\Method;
use Ipag\Classes\Subscription;
use Ipag\Ipag;
use PHPUnit\Framework\TestCase;

class PaymentTest extends TestCase
{
    private $transaction;

    public function __construct()
    {
        parent::__construct();
        $this->init();
    }

    public function setUp()
    {
        parent::setUp();
        $this->init();
    }

    public function init()
    {
        $ipag = new Ipag(new Authentication(getenv('ID_IPAG')), Endpoint::SANDBOX);

        $this->transaction = $ipag->transaction();
        $this->transaction->getOrder()
            ->setOrderId(date('mdHis'))
            ->setCallbackUrl(getenv('CALLBACK_URL'))
            ->setAmount(10.00)
            ->setInstallments(1)
            ->setPayment($ipag->payment()
                    ->setMethod(Method::VISA)
                    ->setCreditCard($ipag->creditCard()
                            ->setNumber('4066553613548107')
                            ->setHolder('FULANO')
                            ->setExpiryMonth('10')
                            ->setExpiryYear('2025')
                            ->setCvc('123')
                    )
            )->setCustomer($ipag->customer()
                ->setName('Fulano da Silva')
                ->setTaxpayerId('799.993.388-01')
                ->setPhone('11', '98888-3333')
                ->setEmail('fulanodasilva@gmail.com')
                ->setAddress($ipag->address()
                        ->setStreet('Rua Júlio Gonzalez')
                        ->setNumber('1000')
                        ->setNeighborhood('Barra Funda')
                        ->setCity('São Paulo')
                        ->setState('SP')
                        ->setZipCode('01156-060')
                )
        );
    }

    public function doPayment()
    {
        return $this->transaction->execute();
    }

    public function testExecutePaymentSuccessfully()
    {
        $transaction = $this->doPayment();

        $this->assertEquals(getenv('APPROVED'), $transaction->payment->status);
    }

    public function testExecuteSubscribePaymentSuccessfully()
    {
        $subscription = new Subscription();

        $subscription->setProfileId(time())
                ->setFrequency(1)
                ->setInterval('month')
                ->setStart(date('d/m/Y'));

        $this->transaction->getOrder()->setSubscription($subscription);

        $response = $this->doPayment();

        $this->assertEquals(getenv('APPROVED'), $response->payment->status);
        $this->assertNotEmpty($response->creditCard->token);
    }
}
