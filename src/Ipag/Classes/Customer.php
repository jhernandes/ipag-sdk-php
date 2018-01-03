<?php

namespace Ipag\Classes;

final class Customer
{
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
     * @return Phone
     */
    public function getPhone()
    {
        if ($this->phone != null) {
            return $this->phone->getAreaCode().$this->phone->getNumber();
        }
        return $this->phone;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = substr((string) $name, 0, 50);

        return $this;
    }

    /**
     * @param string $type
     */
    private function setType()
    {
        if ($this->isIndividual()) {
            $this->type = self::INDIVIDUAL;
        } else {
            $this->type = self::BUSINESS;
        }

        return $this;
    }

    /**
     * @param string $taxpayerId
     */
    public function setTaxpayerId($taxpayerId)
    {
        $this->taxpayerId = substr(Util\Number::getOnlyNumbers($taxpayerId), 0, 14);

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
     * @param Phone $phone
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
}
