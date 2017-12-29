<?php

namespace Ipag\Classes\Util;

final class Number
{
    private function __construct()
    {}

    public static function convertToDouble($number)
    {
        return (double) number_format(str_replace(",", ".", (string) $number), 2, ".", "");
    }

    public static function getOnlyNumbers($string)
    {
        return preg_replace('/\D/', '', $string);
    }
}
