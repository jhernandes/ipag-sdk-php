<?php

namespace Ipag\Classes\Services;

use Ipag\Classes\Contracts\Populable;
use Ipag\Classes\Util\ObjectUtil;
use stdClass;

final class TransactionResponseService implements Populable
{
    /**
     * @var ObjectUtil
     */
    private $objectUtil;

    /**
     * @param stdClass $response
     *
     * @return stdClass
     */
    public function populate(stdClass $response)
    {
        $transaction = $this->transaction($response);

        $transaction->creditCard = $this->creditCard($response);

        if (isset($response->id_assinatura)) {
            $transaction->subscription = $this->subscription($response);
        }

        return $transaction;
    }

    private function getObjectUtil()
    {
        if (is_null($this->objectUtil)) {
            $this->objectUtil = new ObjectUtil();
        }

        return $this->objectUtil;
    }

    private function transaction(stdClass $response)
    {
        $transaction = new stdClass();
        $transaction->tid = $this->getObjectUtil()->getProperty($response, 'id_transacao');
        $transaction->authId = $this->getObjectUtil()->getProperty($response, 'autorizacao_id');
        $transaction->amount = $this->getObjectUtil()->getProperty($response, 'valor');
        $transaction->acquirer = $this->getObjectUtil()->getProperty($response, 'operadora');
        $transaction->acquirerMessage = $this->getObjectUtil()->getProperty($response, 'operadora_mensagem');
        $transaction->urlAuthentication = $this->getObjectUtil()->getProperty($response, 'url_autenticacao');
        $transaction->payment = $this->payment($response);
        $transaction->order = $this->order($response);
        $transaction->antifraud = $this->antifraud($response);

        $transaction->error = $this->getObjectUtil()->getProperty($response, 'code');
        $transaction->errorMessage = $this->getObjectUtil()->getProperty($response, 'message');

        return $transaction;
    }

    private function payment(stdClass $response)
    {
        $payment = new stdClass();
        $payment->status = $this->getObjectUtil()->getProperty($response, 'status_pagamento');
        $payment->message = $this->getObjectUtil()->getProperty($response, 'mensagem_transacao');

        return $payment;
    }

    private function order(stdClass $response)
    {
        $order = new stdClass();
        $order->orderId = $this->getObjectUtil()->getProperty($response, 'num_pedido');

        return $order;
    }

    private function creditCard(stdClass $response)
    {
        $creditCard = new stdClass();
        if (isset($response->token)) {
            $creditCard->token = $this->getObjectUtil()->getProperty($response, 'token');
            $creditCard->last4 = $this->getObjectUtil()->getProperty($response, 'last4');
            $creditCard->expiryMonth = $this->getObjectUtil()->getProperty($response, 'mes');
            $creditCard->expiryYear = $this->getObjectUtil()->getProperty($response, 'ano');
        }

        $card = property_exists($response, 'cartao') ? $response->cartao : null;
        if (!empty($card)) {
            $creditCard->holder = $this->getObjectUtil()->getProperty($card, 'titular');
            $creditCard->number = $this->getObjectUtil()->getProperty($card, 'numero');
            $creditCard->expiry = $this->getObjectUtil()->getProperty($card, 'vencimento');
            $creditCard->brand = $this->getObjectUtil()->getProperty($card, 'bandeira');
        }

        return $creditCard;
    }

    private function subscription(stdClass $response)
    {
        $subscription = new stdClass();
        $subscription->id = $this->getObjectUtil()->getProperty($response, 'id_assinatura');
        $subscription->profileId = $this->getObjectUtil()->getProperty($response, 'profile_id');

        return $subscription;
    }

    private function antifraud(stdClass $response)
    {
        $antifraud = new stdClass();
        $antifraud->id = $this->getObjectUtil()->getProperty($response, 'af_id');
        $antifraud->score = $this->getObjectUtil()->getProperty($response, 'af_score');
        $antifraud->status = $this->getObjectUtil()->getProperty($response, 'af_status');
        $antifraud->message = $this->getObjectUtil()->getProperty($response, 'af_message');

        return $antifraud;
    }
}
