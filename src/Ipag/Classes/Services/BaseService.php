<?php

namespace Ipag\Classes\Services;

use Ipag\Classes\Contracts\Serializable;
use Ipag\Classes\Transaction;

abstract class BaseService
{
    /**
     * @var Transaction
     */
    private $transaction;

    /**
     * @var Serializer
     */
    private $serializer;

    /**
     * @var string
     */
    private $operation;

    /**
     * @var string
     */
    private $action;

    public function __construct(Transaction $transaction)
    {
        $this->transaction = $transaction;
    }

    public function executeAction()
    {
        $this->transaction->getOrder()->setOperation($this->getOperation());

        $action = $this->getAction();

        $response = $this->transaction->sendHttpRequest(
            $this->transaction->getIpag()->getEndpoint()->$action(),
            $this->serializer->serialize()
        );

        return $this->transaction->populate($response);
    }

    /**
     * @param Serializable $serializer
     */
    public function setSerializer(Serializable $serializer)
    {
        $this->serializer = $serializer;

        return $this;
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
    public function getOperation()
    {
        return $this->operation;
    }

    /**
     * @param string $operation
     */
    public function setOperation($operation)
    {
        $this->operation = $operation;

        return $this;
    }

    /**
     * @return string
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * @param string $action
     */
    public function setAction($action)
    {
        $this->action = $action;

        return $this;
    }
}
