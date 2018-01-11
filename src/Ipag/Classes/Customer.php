<?php

namespace Ipag\Classes;

use Ipag\Classes\Contracts\Emptiable;
use Ipag\Classes\Contracts\ObjectSerializable;
use Ipag\Classes\Traits\EmptiableTrait;

final class Customer extends BaseResource implements Emptiable, ObjectSerializable
{
    use EmptiableTrait;

    const INDIVIDUAL = 'f';
    const BUSINESS = 'j';

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $type;

    /**
     * @var string
     */
    private $taxpayerId;

    /**
     * @var string
     */
    private $email;

    /**
     * @var Phone
     */
    private $phone;

    /**
     * @var Address
     */
    private $address;

    /**
     * @return Address
     */
    public function getAddress()
    {
        if (is_null($this->address)) {
            $this->address = new Address();
        }

        return $this->address;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getTaxpayerId()
    {
        return $this->taxpayerId;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getPhone()
    {
        if (is_null($this->phone)) {
            $this->phone = new Phone();
        }

        return $this->phone->getAreaCode().$this->phone->getNumber();
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = substr((string) $name, 0, 50);

        return $this;
    }

    private function setType()
    {
        if ($this->isIndividual()) {
            $this->type = self::INDIVIDUAL;

            return $this;
        }

        $this->type = self::BUSINESS;

        return $this;
    }

    /**
     * @param string $taxpayerId
     */
    public function setTaxpayerId($taxpayerId)
    {
        $this->taxpayerId = substr($this->getNumberUtil()->getOnlyNumbers($taxpayerId), 0, 14);

        $this->setType();

        return $this;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = substr((string) $email, 0, 50);

        return $this;
    }

    /**
     * @param string $areaCode
     * @param string $number
     */
    public function setPhone($areaCode, $number)
    {
        $this->phone = new Phone();
        $this->phone
            ->setAreaCode($areaCode)
            ->setNumber($number);

        return $this;
    }

    /**
     * @param Address $address
     */
    public function setAddress(Address $address)
    {
        $this->address = $address;

        return $this;
    }

    private function isIndividual()
    {
        return (bool) (strlen($this->taxpayerId) <= 11);
    }

    public function serialize()
    {
        if ($this->isEmpty()) {
            return [];
        }

        return array_merge(
            [
                'nome'  => urlencode($this->getName()),
                'email' => urlencode($this->getEmail()),
                'doc'   => urlencode($this->getTaxpayerId()),
                'fone'  => urlencode($this->getPhone()),
            ],
            $this->getAddress()->serialize()
        );
    }
}
