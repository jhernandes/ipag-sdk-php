<?php

namespace Ipag\Classes\Util;

class ObjectUtil
{
    public static function getProperty($object, $property)
    {
        if (!property_exists($object, $property)) {
            return null;
        }

        return !empty($object->$property) && is_string($object->$property) ? $object->$property : null;
    }
}
