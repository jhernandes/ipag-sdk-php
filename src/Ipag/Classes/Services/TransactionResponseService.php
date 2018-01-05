<?php

namespace Ipag\Classes\Services;

use Ipag\Classes\Contracts\Populable;
use Ipag\Classes\Util\ObjectUtil;
use stdClass;

final class TransactionResponseService implements Populable
{
    public function populate(stdClass $response)
    {
        $objectUtil = new ObjectUtil();
        $transaction = new stdClass();
        $transaction->tid = $objectUtil->getProperty($response, 'id_transacao');
        $transaction->acquirer = $objectUtil->getProperty($response, 'operadora');
        $transaction->acquirerMessage = $objectUtil->getProperty($response, 'operadora_mensagem');
        $transaction->urlAthentication = $objectUtil->getProperty($response, 'url_autenticacao');
        $transaction->payment = new stdClass();
        $transaction->payment->status = $objectUtil->getProperty($response, 'status_pagamento');
        $transaction->payment->message = $objectUtil->getProperty($response, 'mensagem_transacao');

        $transaction->order = new stdClass();
        $transaction->order->orderId = $objectUtil->getProperty($response, 'num_pedido');

        if (isset($response->token)) {
            $transaction->creditCard = new stdClass();
            $transaction->creditCard->token = $objectUtil->getProperty($response, 'token');
            $transaction->creditCard->last4 = $objectUtil->getProperty($response, 'last4');
            $transaction->creditCard->expiryMonth = $objectUtil->getProperty($response, 'mes');
            $transaction->creditCard->expiryYear = $objectUtil->getProperty($response, 'ano');
        }

        if (isset($response->id_assinatura)) {
            $transaction->subscription = new stdClass();
            $transaction->subscription->id = $objectUtil->getProperty($response, 'id_assinatura');
            $transaction->subscription->profileId = $objectUtil->getProperty($response, 'profile_id');
        }

        return $transaction;
    }
}
