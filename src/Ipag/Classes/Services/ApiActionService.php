<?php

namespace Ipag\Classes\Services;

use Ipag\Classes\Contracts\Operationable;
use Ipag\Classes\Contracts\Serializable;

final class ApiActionService implements Operationable
{
    /**
     * @var Serializable
     */
    private $serializer;

    /**
     * @param Serializable $serializer
     */
    public function setSerializer(Serializable $serializer)
    {
        $this->serializer = $serializer;

        return $this;
    }

    /**
     * @param Serializable $serializer
     *
     * @return \stdClass
     */
    public function execute(Serializable $serializer)
    {
        return $this->setSerializer($serializer)->executeAction();
    }

    public function executeAction()
    {
        $transaction = $this->serializer->getTransaction();

        $transaction->getOrder()->setOperation($this->serializer->getOperation());

        $action = $this->serializer->getAction();

        $transaction->authenticate();

        $response = $transaction->sendHttpRequest(
            $transaction->getIpag()->getEndpoint()->$action(),
            $this->serializer->serialize()
        );

        return $transaction->populate($response);
    }
}
