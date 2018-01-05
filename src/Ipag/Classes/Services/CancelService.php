<?php

namespace Ipag\Classes\Services;

use Ipag\Classes\Contracts\Operationable;
use Ipag\Classes\Enum\Action;
use Ipag\Classes\Enum\Operation;
use Ipag\Classes\Serializer\CancelSerializer;

final class CancelService extends BaseService implements Operationable
{
    public function execute()
    {
        $this
            ->setAction(Action::CANCEL)
            ->setOperation(Operation::CANCEL)
            ->setSerializer(new CancelSerializer($this->getTransaction()));

        return $this->executeAction();
    }
}
