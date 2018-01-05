<?php

namespace Ipag\Classes;

abstract class BaseResource
{
    /**
     * @var Util\NumberUtil
     */
    private $numberUtil;

    /**
     * @var Util\DateUtil
     */
    private $dateUtil;

    /**
     * @return Util\NumberUtil
     */
    public function getNumberUtil()
    {
        if (is_null($this->numberUtil)) {
            $this->numberUtil = new Util\NumberUtil();
        }

        return $this->numberUtil;
    }

    /**
     * @return Util\DateUtil
     */
    public function getDateUtil()
    {
        if (is_null($this->dateUtil)) {
            $this->dateUtil = new Util\DateUtil();
        }

        return $this->dateUtil;
    }
}
