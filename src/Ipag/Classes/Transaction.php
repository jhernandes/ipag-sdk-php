<?php

namespace Ipag\Classes;

use Ipag\Classes\Util\ObjectUtil;
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
        $transaction = new stdClass;
        $transaction->tid = ObjectUtil::getProperty($response, 'id_transacao');
        $transaction->acquirer = ObjectUtil::getProperty($response, 'operadora');
        $transaction->acquirerMessage = ObjectUtil::getProperty($response, 'operadora_mensagem');
        $transaction->urlAthentication = ObjectUtil::getProperty($response, 'url_autenticacao');
        $transaction->payment = new stdClass;
        $transaction->payment->status = ObjectUtil::getProperty($response, 'status_pagamento');
        $transaction->payment->message = ObjectUtil::getProperty($response, 'mensagem_transacao');

        $transaction->order = new stdClass;
        $transaction->order->orderId = ObjectUtil::getProperty($response, 'num_pedido');

        if (isset($response->token)) {
            $transaction->creditCard = new stdClass;
            $transaction->creditCard->token = ObjectUtil::getProperty($response, 'token');
            $transaction->creditCard->last4 = ObjectUtil::getProperty($response, 'last4');
            $transaction->creditCard->expiryMonth = ObjectUtil::getProperty($response, 'mes');
            $transaction->creditCard->expiryYear = ObjectUtil::getProperty($response, 'ano');
        }

        if (isset($response->id_assinatura)) {
            $transaction->subscription = new stdClass;
            $transaction->subscription->id = ObjectUtil::getProperty($response, 'id_assinatura');
            $transaction->subscription->profileId = ObjectUtil::getProperty($response, 'profile_id');
        }

        return $transaction;
    }

    public function execute()
    {
        if ($this->getOrder() == null) {
            throw new \Exception('É necessário inicializar o pedido (Order).');
        }

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
