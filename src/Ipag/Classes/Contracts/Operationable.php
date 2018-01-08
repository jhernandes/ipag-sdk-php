<?php

namespace Ipag\Classes\Contracts;

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
