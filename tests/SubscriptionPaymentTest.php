<?php

namespace Tests;

use Ipag\Classes\Authentication;
use Ipag\Classes\Endpoint;
use Ipag\Classes\Enum\Method;
use Ipag\Ipag;
use PHPUnit\Framework\TestCase;

class SubscriptionPaymentTest extends TestCase
{
    public function doPayment($identification, $orderId = null)
    {
        if ($orderId == null) {
            $orderId = date("mdHis");
        }

        $ipag = new Ipag(new Authentication($identification), Endpoint::SANDBOX);

        $order = $ipag->order()
            ->setOrderId($orderId)
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
        )->setSubscription($ipag->subscription()
                ->setProfileId(time())
                ->setFrequency(1)
                ->setInterval('month')
                ->setStart(date('d/m/Y'))
        );

        return $ipag->transaction()->setOrder($order)->execute();
    }

    public function testExecutePaymentSuccessfully()
    {
        $orderId = date("mdHis");
        $transaction = $this->doPayment(getenv('ID_IPAG'), $orderId);

        $this->assertEquals(getenv('APPROVED'), $transaction->payment->status);
        $this->assertEquals($orderId, $transaction->order->orderId);
    }
}
