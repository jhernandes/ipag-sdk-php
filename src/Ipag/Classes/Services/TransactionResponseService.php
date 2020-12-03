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
        $transaction->id = $this->getObjectUtil()->getProperty($response, 'id');
        $transaction->tid = $this->getObjectUtil()->getProperty($response, 'id_transacao');
        $transaction->authId = $this->getObjectUtil()->getProperty($response, 'autorizacao_id');
        $transaction->amount = $this->getObjectUtil()->getProperty($response, 'valor');
        $transaction->acquirer = $this->getObjectUtil()->getProperty($response, 'operadora');
        $transaction->acquirerMessage = $this->getObjectUtil()->getProperty($response, 'operadora_mensagem');
        $transaction->urlAuthentication = $this->getObjectUtil()->getProperty($response, 'url_autenticacao');
        $transaction->urlCallback = $this->getObjectUtil()->getProperty($response, 'url_retorno');
        $transaction->createAt = $this->getObjectUtil()->getProperty($response, 'criado_em');
        $transaction->payment = $this->payment($response);
        $transaction->order = $this->order($response);
        $transaction->customer = $this->customer($response);
        $transaction->antifraud = $this->antifraud($response);
        $transaction->splitRules = $this->splitRules($response);
        $transaction->error = $this->getObjectUtil()->getProperty($response, 'code');
        $transaction->errorMessage = $this->getObjectUtil()->getProperty($response, 'message');
        $transaction->history = $this->history($response);

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

    private function customer(stdClass $response)
    {
        $customer = new stdClass();
        $customer_params = property_exists($response, 'cliente') ? $response->cliente : null;
        if (!empty($customer_params)) {
            $customer->name = $this->getObjectUtil()->getProperty($customer_params, 'nome');
            $customer->email = $this->getObjectUtil()->getProperty($customer_params, 'email');
            $customer->phone = $this->getObjectUtil()->getProperty($customer_params, 'telefone');
            $customer->cpfCnpj = $this->getObjectUtil()->getProperty($customer_params, 'cnpj_cnpj');
            $customer_address = property_exists($customer_params, 'endereco') ? $customer_params->endereco : null;

            if (!empty($customer_address)) {
                $address = new stdClass();
                $address->street = $this->getObjectUtil()->getProperty($customer_address, 'logradouro');
                $address->number = $this->getObjectUtil()->getProperty($customer_address, 'numero');
                $address->complement = $this->getObjectUtil()->getProperty($customer_address, 'complemento');
                $address->district = $this->getObjectUtil()->getProperty($customer_address, 'bairro');
                $address->city = $this->getObjectUtil()->getProperty($customer_address, 'cidade');
                $address->state = $this->getObjectUtil()->getProperty($customer_address, 'estado');
                $address->zipCode = $this->getObjectUtil()->getProperty($customer_address, 'cep');

                $customer->address = $address;
            }
        }

        return $customer;
    }

    private function history(stdClass $response)
    {
        $histories = [];
        $histories_params = property_exists($response, 'historicos') ? $response->historicos : null;
        if (!empty($histories_params)) {
            foreach ($histories_params as $history_params) {
                $history = new stdClass();
                $history->amount = $this->getObjectUtil()->getProperty($history_params, 'valor');
                $history->operationType = $this->getObjectUtil()->getProperty($history_params, 'tipo');
                $history->status = $this->getObjectUtil()->getProperty($history_params, 'status');
                $history->responseCode = $this->getObjectUtil()->getProperty($history_params, 'codigo_resposta');
                $history->responseMessage = $this->getObjectUtil()->getProperty($history_params, 'mensagem_resposta');
                $history->authorizationCode = $this->getObjectUtil()->getProperty($history_params, 'codigo_autorizacao');
                $history->authorizationId = $this->getObjectUtil()->getProperty($history_params, 'id_autorizacao');
                $history->authorizationNsu = $this->getObjectUtil()->getProperty($history_params, 'nsu_autorizacao');
                $history->createdAt = $this->getObjectUtil()->getProperty($history_params, 'criado_em');
                $histories[] = $history;
            }
        }

        return $histories;
    }

    private function splitRules(stdClass $response)
    {
        $splitRules = [];
        $split_rules = property_exists($response, 'split_rules') ? $response->split_rules : null;
        if (!empty($split_rules)) {
            foreach ($split_rules as $split_rule) {
                $splitRule = new stdClass();
                $splitRule->rule = $this->getObjectUtil()->getProperty($split_rule, 'rule');
                $splitRule->seller_id = $this->getObjectUtil()->getProperty($split_rule, 'recipient');
                $splitRule->ipag_id = $this->getObjectUtil()->getProperty($split_rule, 'ipag_id');
                $splitRule->amount = $this->getObjectUtil()->getProperty($split_rule, 'amount');
                $splitRule->percentage = $this->getObjectUtil()->getProperty($split_rule, 'percentage');
                $splitRule->liable = $this->getObjectUtil()->getProperty($split_rule, 'liable');
                $splitRule->charge_processing_fee = $this->getObjectUtil()->getProperty($split_rule, 'charge_processing_fee');
                $splitRules[] = $splitRule;
            }
        }

        return $splitRules;
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
        $antifraud->score = null;
        $antifraud->status = null;
        $antifraud->message = null;

        $antifraude_params = property_exists($response, 'antifraude') ? $response->antifraude : null;
        if (!empty($antifraude_params)) {
            $antifraud->score = $this->getObjectUtil()->getProperty($antifraude_params, 'score');
            $antifraud->status = $this->getObjectUtil()->getProperty($antifraude_params, 'status');
            $antifraud->message = strip_tags((string) $this->getObjectUtil()->getProperty($antifraude_params, 'message'));
        }

        return $antifraud;
    }
}
