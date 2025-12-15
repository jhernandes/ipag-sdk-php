<?php

namespace Ipag\Classes\Serializer;

use Ipag\Classes\Contracts\Serializable;
use Ipag\Classes\Transaction;

class Serializer implements Serializable
{
    /**
     * @var Transaction
     */
    protected $transaction;

    /**
     * @var string
     */
    protected $action;

    /**
     * @var string
     */
    protected $operation;

    public function __construct(Transaction $transaction, $action, $operation)
    {
        $this->transaction = $transaction;
        $this->action = $action;
        $this->operation = $operation;
    }

    public function serialize()
    {
        $response = [
            'identificacao' => urlencode((string) $this->transaction->getIpag()->getAuthentication()->getIdentification()),
            'transId'       => urlencode((string) $this->transaction->getTid()),
            'numPedido'     => urlencode((string) $this->transaction->getNumPedido()),
            'retorno_tipo'  => urlencode('xml'),
        ];

        $amount = $this->transaction->getOrder()->getAmount();
        if (!empty($amount)) {
            $response['valor'] = $amount;
        }

        return $response;
    }

    /**
     * @return Transaction
     */
    public function getTransaction()
    {
        return $this->transaction;
    }

    /**
     * @return string
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * @return string
     */
    public function getOperation()
    {
        return $this->operation;
    }
}
