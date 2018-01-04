<?php

namespace Tests\Classes;

use Ipag\Classes\Authentication;
use Ipag\Classes\Enum\Method;
use Ipag\Ipag;
use PHPUnit\Framework\TestCase;

class TransactionTest extends TestCase
{
    public function testExecuteShouldThrowExceptionXmlError()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Não foi possível identificar o XML de retorno.');

        $ipag = new Ipag(new Authentication('test@test.com'), 'http://google.com.br');

        $order = $ipag->order()
            ->setOrderId('100000')
            ->setCallbackUrl(getenv('CALLBACK_URL'))
            ->setAmount(10.00)
            ->setInstallments(1)
            ->setPayment($ipag->payment()
                    ->setMethod(Method::BANKSLIP_ITAU)
            );

        $ipag->transaction()->setOrder($order)->execute();
    }
}
