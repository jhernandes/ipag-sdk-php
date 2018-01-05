<?php

namespace Ipag\Classes\Services;

use Ipag\Classes\Contracts\Operationable;
use Ipag\Classes\Enum\Action;
use Ipag\Classes\Enum\Operation;
use Ipag\Classes\Serializer\PaymentSerializer;

final class PaymentService extends BaseService implements Operationable
{
    public function execute()
    {
        $this
            ->setAction(Action::PAYMENT)
            ->setOperation(Operation::PAYMENT)
            ->setSerializer(new PaymentSerializer($this->getTransaction()));

        return $this->executeAction();
    }
}
