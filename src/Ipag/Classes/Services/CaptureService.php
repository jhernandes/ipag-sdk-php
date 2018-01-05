<?php

namespace Ipag\Classes\Services;

use Ipag\Classes\Contracts\Operationable;
use Ipag\Classes\Enum\Action;
use Ipag\Classes\Enum\Operation;
use Ipag\Classes\Serializer\CaptureSerializer;

final class CaptureService extends BaseService implements Operationable
{
    public function execute()
    {
        $this
            ->setAction(Action::CAPTURE)
            ->setOperation(Operation::CAPTURE)
            ->setSerializer(new CaptureSerializer($this->getTransaction()));

        return $this->executeAction();
    }
}
