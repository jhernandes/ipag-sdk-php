<?php

namespace Ipag\Classes\Contracts;

interface Operationable
{
    /**
     * @return stdClass
     */
    public function execute();
}
