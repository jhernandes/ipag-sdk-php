<?php

namespace Ipag\Classes;

final class CreditCard
{
    /**
     * @var string
     */
    private $number;

    /**
     * @var string
     */
    private $holder;

    /**
     * @var string
     */
    private $expiryMonth;

    /**
     * @var string
     */
    private $expiryYear;

    /**
     * @var string
     */
    private $cvc;

    /**
     * @var string
     */
    private $token;

    /**
     * @var bool
     */
    private $save;

    /**
     * @return string
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * @return string
     */
    public function getHolder()
    {
        return $this->holder;
    }

    /**
     * @return string
     */
    public function getExpiryMonth()
    {
        return $this->expiryMonth;
    }

    /**
     * @return string
     */
    public function getExpiryYear()
    {
        return $this->expiryYear;
    }

    /**
     * @return string
     */
    public function getCvc()
    {
        return $this->cvc;
    }

    /**
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @param string number
     */
    public function setNumber($number)
    {
        $this->number = Util\Number::getOnlyNumbers($number);

        return $this;
    }

    /**
     * @param string holder
     */
    public function setHolder($holder)
    {
        $this->holder = substr((string) $holder, 0, 50);

        return $this;
    }

    /**
     * @param string expiryMonth
     */
    public function setExpiryMonth($expiryMonth)
    {
        if (!$this->isValidMonth($expiryMonth)) {
            throw new \UnexpectedValueException(
                'O mês de expiração do cartão deve ser um número entre 1 e 12'
            );
        }
        $this->expiryMonth = $expiryMonth;

        return $this;
    }

    /**
     * @param string expiryYear
     */
    public function setExpiryYear($expiryYear)
    {
        if (!$this->isValidYear($expiryYear)) {
            throw new \UnexpectedValueException(
                'O ano de expiração do cartão deve ser um número de 2 ou 4 dígitos'
            );
        }
        $this->expiryYear = sprintf('20%d', substr($expiryYear, -2, 2));

        return $this;
    }

    /**
     * @param string cvc
     */
    public function setCvc($cvc)
    {
        if (!$this->isValidCvc($cvc)) {
            throw new \UnexpectedValueException(
                'O código de segurança deve ser um número e deve ter 3 ou 4 dígitos'
            );
        }
        $this->cvc = $cvc;

        return $this;
    }

    /**
     * @param string token
     */
    public function setToken($token)
    {
        $this->token = (string) $token;

        return $this;
    }

    /**
     * @return boolean
     */
    public function getSave()
    {
        return (boolean) $this->save;
    }

    /**
     * @param boolean $save
     */
    public function setSave($save)
    {
        $this->save = (boolean) $save;

        return $this;
    }

    private function isValidMonth($month)
    {
        return (boolean) (is_numeric($month) && $month >= 1 && $month <= 12);
    }

    private function isValidYear($year)
    {
        return (boolean) (is_numeric($year) && strlen($year) >= 2 && strlen($year) <= 4);
    }

    private function isValidCvc($cvc)
    {
        return (boolean) (is_numeric($cvc) && (strlen($cvc) == 3 || strlen($cvc) == 4));
    }

    public function hasToken()
    {
        return !empty($this->token);
    }

    public function hasCvc()
    {
        return !empty($this->cvc);
    }
}
