<?php

namespace Ipag\Classes;

use Ipag\Classes\Contracts\Emptiable;
use Ipag\Classes\Traits\EmptiableTrait;

final class SplitRule extends BaseResource implements Emptiable
{
    use EmptiableTrait;

    /**
     * @var string
     */
    private $sellerId;

    /**
     * @var int
     */
    private $percentage;

    /**
     * @var float
     */
    private $amount;

    /**
     * @var int
     */
    private $liable;

    /**
     * @var int
     */
    private $chargeProcessingFee;

    /**
     * @return string
     */
    public function getSellerId()
    {
        return $this->sellerId;
    }

    /**
     * @param string $sellerId
     *
     * @return self
     */
    public function setSellerId($sellerId)
    {
        $this->sellerId = $sellerId;

        return $this;
    }

    /**
     * @return int
     */
    public function getPercentage()
    {
        return $this->percentage;
    }

    /**
     * @param int $percentage
     *
     * @return self
     */
    public function setPercentage($percentage)
    {
        $this->percentage = intval($percentage);

        return $this;
    }

    /**
     * @return float
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param float $amount
     *
     * @return self
     */
    public function setAmount($amount)
    {
        $this->amount = $this->getNumberUtil()->convertToDouble($amount);

        return $this;
    }

    /**
     * @return int
     */
    public function getLiable()
    {
        return $this->liable;
    }

    /**
     * @param int $liable
     *
     * @return self
     */
    public function setLiable($liable = 1)
    {
        $this->liable = intval($liable);

        return $this;
    }

    /**
     * @return int
     */
    public function getChargeProcessingFee()
    {
        return $this->chargeProcessingFee;
    }

    /**
     * @param int $chargeProcessingFee
     *
     * @return self
     */
    public function setChargeProcessingFee($chargeProcessingFee = 0)
    {
        $this->chargeProcessingFee = intval($chargeProcessingFee);

        return $this;
    }
}
