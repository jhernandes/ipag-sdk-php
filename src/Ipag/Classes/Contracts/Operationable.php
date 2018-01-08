<?php

namespace Ipag\Classes\Contracts;

use Ipag\Classes\Contracts\Serializable;
use stdClass;

interface Operationable
{
    /**
     * @param Serializable $serialize
     *
     * @return stdClass
     */
    public function execute(Serializable $serialize);
}
