<?php

namespace Ipag\Classes;

abstract class BaseResource
{
    /**
     * @var Util\NumberUtil
     */
    private $numberUtil;

    /**
     * @var Util\ObjectUtil
     */
    private $objectUtil;

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
     * @return Util\ObjectUtil
     */
    public function getObjectUtil()
    {
        if (is_null($this->objectUtil)) {
            $this->objectUtil = new Util\ObjectUtil();
        }

        return $this->objectUtil;
    }
}
