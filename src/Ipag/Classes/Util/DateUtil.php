<?php

namespace Ipag\Classes\Util;

final class DateUtil
{
    public function isValid($date)
    {
        if (preg_match("/([0-9]{2})\/([0-9]{2})\/([0-9]{4})/", $date, $matches)) {
            if (checkdate($matches[2], $matches[1], $matches[3])) {
                return true;
            }
        }

        return false;
    }
}
