<?php

namespace Ipag\Classes;

final class Address
{
    /**
     * @var string
     */
    private $street;

    /**
     * @var string
     */
    private $number;

    /**
     * @var string
     */
    private $complement;

    /**
     * @var string
     */
    private $neighborhood;

    /**
     * @var string
     */
    private $city;

    /**
     * @var string
     */
    private $state;

    /**
     * @var string
     */
    private $country;

    /**
     * @var string
     */
    private $zipCode;

    public function __construct()
    {
        $this->setCountry('BR');

        return $this;
    }

    /**
     * @return string
     */
    public function getStreet()
    {
        return $this->street;
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
    public function getComplement()
    {
        return $this->complement;
    }

    /**
     * @return string
     */
    public function getNeighborhood()
    {
        return $this->neighborhood;
    }

    /**
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @return string
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @return string
     */
    public function getZipCode()
    {
        return $this->zipCode;
    }

    /**
     * @param string street
     */
    public function setStreet($street)
    {
        $this->street = substr((string) $street, 0, 100);

        return $this;
    }

    /**
     * @param string number
     */
    public function setNumber($number)
    {
        $this->number = substr((string) $number, 0, 15);

        return $this;
    }

    /**
     * @param string complement
     */
    public function setComplement($complement)
    {
        $this->complement = substr((string) $complement, 0, 255);

        return $this;
    }

    /**
     * @param string neighborhood
     */
    public function setNeighborhood($neighborhood)
    {
        $this->neighborhood = substr((string) $neighborhood, 0, 40);

        return $this;
    }

    /**
     * @param string city
     */
    public function setCity($city)
    {
        $this->city = substr((string) $city, 0, 40);

        return $this;
    }

    /**
     * @param string state
     */
    public function setState($state)
    {
        $this->state = substr((string) $state, 0, 2);

        return $this;
    }

    /**
     * @param string country
     */
    public function setCountry($country)
    {
        $this->country = substr($country, 0, 3);

        return $this;
    }

    /**
     * @param string zipCode
     */
    public function setZipCode($zipCode)
    {
        $this->zipCode = substr(Util\Number::getOnlyNumbers($zipCode), 0, 8);

        return $this;
    }
}
