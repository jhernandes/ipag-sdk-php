<?php

namespace Ipag\Classes\Traits;

trait EmptiableTrait
{
    public function isEmpty()
    {
        $properties = array_filter(get_object_vars($this));

        return empty($properties);
    }
}
