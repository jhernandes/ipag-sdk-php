<?php

namespace Ipag\Classes;

use Ipag\Classes\Contracts\Emptiable;
use Ipag\Classes\Contracts\ObjectSerializable;
use Ipag\Classes\Traits\EmptiableTrait;

final class CreditCard extends BaseResource implements Emptiable, ObjectSerializable
{
    use EmptiableTrait;

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
     * @var Validators\CreditCardValidator
     */
    private $validator;

    private function validator()
    {
        if (is_null($this->validator)) {
            $this->validator = new Validators\CreditCardValidator();
        }

        return $this->validator;
    }

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
     * @param string $number
     */
    public function setNumber($number)
    {
        $this->number = $this->getNumberUtil()->getOnlyNumbers($number);

        return $this;
    }

    /**
     * @param string $holder
     */
    public function setHolder($holder)
    {
        $this->holder = substr((string) $holder, 0, 50);

        return $this;
    }

    /**
     * @param string $expiryMonth
     */
    public function setExpiryMonth($expiryMonth)
    {
        if (!$this->validator()->isValidMonth($expiryMonth)) {
            throw new \UnexpectedValueException(
                'O mês de expiração do cartão deve ser um número entre 1 e 12'
            );
        }
        $this->expiryMonth = $expiryMonth;

        return $this;
    }

    /**
     * @param string $expiryYear
     */
    public function setExpiryYear($expiryYear)
    {
        if (!$this->validator()->isValidYear($expiryYear)) {
            throw new \UnexpectedValueException(
                'O ano de expiração do cartão deve ser um número de 2 ou 4 dígitos'
            );
        }
        $this->expiryYear = sprintf('20%d', substr($expiryYear, -2, 2));

        return $this;
    }

    /**
     * @param string $cvc
     */
    public function setCvc($cvc)
    {
        if (!$this->validator()->isValidCvc($cvc)) {
            throw new \UnexpectedValueException(
                'O código de segurança deve ser um número e deve ter 3 ou 4 dígitos'
            );
        }
        $this->cvc = $cvc;

        return $this;
    }

    /**
     * @param string $token
     */
    public function setToken($token)
    {
        $this->token = (string) $token;

        return $this;
    }

    /**
     * @return bool
     */
    public function hasSave()
    {
        return (bool) $this->save;
    }

    /**
     * @param bool $save
     */
    public function setSave($save)
    {
        $this->save = (bool) $save;

        return $this;
    }

    /**
     * @return bool
     */
    public function hasToken()
    {
        return (bool) !empty($this->token);
    }

    /**
     * @return bool
     */
    public function hasCvc()
    {
        return (bool) !empty($this->cvc);
    }

    public function hide()
    {
        $this->number = preg_replace('/^(\d{6})(\d+)(\d{4})$/', '$1******$3', $this->number);
        $this->cvc = preg_replace('/\d/', '*', $this->cvc);
    }

    public function serialize()
    {
        if ($this->isEmpty()) {
            return [];
        }

        if ($this->hasToken()) {
            return $this->serializeCreditCardWithToken();
        }

        return $this->serializeCreditCardWithNumber();
    }

    private function serializeCreditCardWithNumber()
    {
        $_creditCard = [
            'num_cartao'  => urlencode($this->getNumber()),
            'nome_cartao' => urlencode($this->getHolder()),
            'mes_cartao'  => urlencode($this->getExpiryMonth()),
            'ano_cartao'  => urlencode($this->getExpiryYear()),
        ];

        if ($this->hasCvc()) {
            $_creditCard['cvv_cartao'] = urlencode($this->getCvc());
        }

        if ($this->hasSave()) {
            $_creditCard['gera_token_cartao'] = $this->hasSave();
        }

        return $_creditCard;
    }

    private function serializeCreditCardWithToken()
    {
        $_creditCard = [
            'token_cartao' => urlencode($this->getToken()),
        ];

        if ($this->hasCvc()) {
            $_creditCard['cvv_cartao'] = urlencode($this->getCvc());
        }

        return $_creditCard;
    }
}
