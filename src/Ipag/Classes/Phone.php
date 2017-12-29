<?php

namespace Ipag\Classes;

final class Phone
{
    /**
     * @var string
     */
    private $areaCode;

    /**
     * @var string
     */
    private $number;

    /**
     * @return string
     */
    public function getAreaCode()
    {
        return $this->areaCode;
    }

    /**
     * @return string
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * @param string $areaCode
     */
    public function setAreaCode($areaCode)
    {
        $this->areaCode = substr(Util\Number::getOnlyNumbers($areaCode), 0, 2);

        return $this;
    }

    /**
     * @param string $number
     */
    public function setNumber($number)
    {
        $this->number = Util\Number::getOnlyNumbers($number);

        return $this;
    }
}
