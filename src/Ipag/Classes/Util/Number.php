<?php

namespace Ipag\Classes\Util;

final class Number
{
    public static function convertToDouble($number)
    {
        $number = str_replace(",", ".", (string) $number);

        if (!is_numeric($number)) {
            throw new \UnexpectedValueException("{$number} não é um número válido");
        }

        return (double) number_format($number, 2, ".", "");
    }

    public static function getOnlyNumbers($string)
    {
        return preg_replace('/\D/', '', $string);
    }
}
