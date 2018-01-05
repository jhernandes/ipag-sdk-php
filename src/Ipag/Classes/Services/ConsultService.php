<?php

namespace Ipag\Classes\Services;

use Ipag\Classes\Contracts\Operationable;
use Ipag\Classes\Enum\Action;
use Ipag\Classes\Enum\Operation;
use Ipag\Classes\Serializer\ConsultSerializer;

final class ConsultService extends BaseService implements Operationable
{
    public function execute()
    {
        $this
            ->setAction(Action::CONSULT)
            ->setOperation(Operation::CONSULT)
            ->setSerializer(new ConsultSerializer($this->getTransaction()));

        return $this->executeAction();
    }
}
