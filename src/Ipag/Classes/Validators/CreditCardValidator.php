<?php

namespace Ipag\Classes\Validators;

final class CreditCardValidator
{
    public function isValidMonth($month)
    {
        return (bool) (is_numeric($month) && $month >= 1 && $month <= 12);
    }

    public function isValidYear($year)
    {
        return (bool) (is_numeric($year) && strlen($year) >= 2 && strlen($year) <= 4);
    }

    public function isValidCvc($cvc)
    {
        return (bool) (is_numeric($cvc) && (strlen($cvc) == 3 || strlen($cvc) == 4));
    }
}
