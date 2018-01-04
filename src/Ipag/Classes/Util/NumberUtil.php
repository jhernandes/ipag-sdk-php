<?php

namespace Ipag\Classes\Util;

final class NumberUtil
{
    /**
     * @param mixed $number
     *
     * @return float
     */
    public function convertToDouble($number)
    {
        $number = str_replace(',', '.', (string) $number);

        if (!is_numeric($number)) {
            throw new \UnexpectedValueException("{$number} não é um número válido");
        }

        return (float) number_format($number, 2, '.', '');
    }

    /**
     * @param string $string
     *
     * @return string
     */
    public function getOnlyNumbers($string)
    {
        return (string) preg_replace('/\D/', '', $string);
    }
}
