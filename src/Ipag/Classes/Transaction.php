<?php

namespace Ipag\Classes;

use stdClass;

final class Transaction extends IpagResource
{
    /**
     * @var Order
     */
    private $order;

    /**
     * @var string
     */
    private $tid;

    /**
     * @return string
     */
    public function getTid()
    {
        return $this->tid;
    }

    /**
     * @param string $tid
     */
    public function setTid($tid)
    {
        $this->tid = $tid;

        return $this;
    }

    /**
     * @return Order
     */
    public function getOrder()
    {
        if (is_null($this->order)) {
            $this->order = new Order();
        }

        return $this->order;
    }

    /**
     * @param Order $order
     */
    public function setOrder(Order $order)
    {
        $this->order = $order;

        return $this;
    }

    protected function populate(stdClass $response)
    {
        $objectUtil = $this->getObjectUtil();
        $transaction = new stdClass();
        $transaction->tid = $objectUtil->getProperty($response, 'id_transacao');
        $transaction->acquirer = $objectUtil->getProperty($response, 'operadora');
        $transaction->acquirerMessage = $objectUtil->getProperty($response, 'operadora_mensagem');
        $transaction->urlAthentication = $objectUtil->getProperty($response, 'url_autenticacao');
        $transaction->payment = new stdClass();
        $transaction->payment->status = $objectUtil->getProperty($response, 'status_pagamento');
        $transaction->payment->message = $objectUtil->getProperty($response, 'mensagem_transacao');

        $transaction->order= new stdClass();
        $transaction->order->orderId = $objectUtil->getProperty($response, 'num_pedido');

        if (isset($response->token)) {
            $transaction->creditCard = new stdClass();
            $transaction->creditCard->token = $objectUtil->getProperty($response, 'token');
            $transaction->creditCard->last4 = $objectUtil->getProperty($response, 'last4');
            $transaction->creditCard->expiryMonth = $objectUtil->getProperty($response, 'mes');
            $transaction->creditCard->expiryYear  = $objectUtil->getProperty($response, 'ano');
        }

        if (isset($response->id_assinatura)) {
            $transaction->subscription = new stdClass();
            $transaction->subscription->id = $objectUtil->getProperty($response, 'id_assinatura');
            $transaction->subscription->profileId = $objectUtil->getProperty($response, 'profile_id');
        }

        return $transaction;
    }

    public function execute()
    {
        $this->getOrder()->setOperation(Enum\Operation::PAYMENT);

        $serializer = new Serializer\PaymentSerializer($this);

        $response = $this->sendHttpRequest($this->getIpag()->getEndpoint()->payment(), $serializer->serialize());

        return $this->populate($response);
    }

    public function consult()
    {
        $this->getOrder()->setOperation(Enum\Operation::CONSULT);

        $serializer = new Serializer\ConsultSerializer($this);

        $response = $this->sendHttpRequest($this->getIpag()->getEndpoint()->consult(), $serializer->serialize());

        return $this->populate($response);
    }

    public function cancel()
    {
        $this->getOrder()->setOperation(Enum\Operation::CANCEL);

        $serializer = new Serializer\CancelSerializer($this);

        $response = $this->sendHttpRequest($this->getIpag()->getEndpoint()->cancel(), $serializer->serialize());

        return $this->populate($response);
    }

    public function capture()
    {
        $this->getOrder()->setOperation(Enum\Operation::CAPTURE);

        $serializer = new Serializer\CaptureSerializer($this);

        $response = $this->sendHttpRequest($this->getIpag()->getEndpoint()->capture(), $serializer->serialize());

        return $this->populate($response);
    }
}
