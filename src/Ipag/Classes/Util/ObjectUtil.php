<?php

namespace Ipag\Classes\Util;

final class ObjectUtil
{
    public function getProperty($object, $property)
    {
        if (!property_exists($object, $property)) {
            return;
        }

        return isset($object->$property) && is_string($object->$property) ? $object->$property : null;
    }
}
