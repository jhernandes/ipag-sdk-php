<?php

namespace Ipag\Classes\Contracts;

use stdClass;

interface Populable
{
    /**
     * @param stdClass $response
     *
     * @return stdClass
     */
    public function populate(stdClass $response);
}
