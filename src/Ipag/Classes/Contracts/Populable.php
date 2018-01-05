<?php

namespace Ipag\Classes\Contracts;

use stdClass;

interface Populable
{
    /**
     * @param stdClass $object
     *
     * @return stdClass
     */
    public function populate(stdClass $response);
}
