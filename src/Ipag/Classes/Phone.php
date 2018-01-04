<?php

namespace Ipag\Classes;

use Ipag\Classes\Contracts\Emptiable;
use Ipag\Classes\Traits\EmptiableTrait;

final class Phone extends BaseResource implements Emptiable
{
    use EmptiableTrait;

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
        $this->areaCode = substr($this->getNumberUtil()->getOnlyNumbers($areaCode), 0, 2);

        return $this;
    }

    /**
     * @param string $number
     */
    public function setNumber($number)
    {
        $this->number = $this->getNumberUtil()->getOnlyNumbers($number);

        return $this;
    }
}
