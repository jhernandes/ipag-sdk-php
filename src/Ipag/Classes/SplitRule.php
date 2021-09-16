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
     * @var float
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
     * @var int
     */
    private $holdReceivables;

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
     * @return float
     */
    public function getPercentage()
    {
        return $this->percentage;
    }

    /**
     * @param float $percentage
     *
     * @return self
     */
    public function setPercentage($percentage)
    {
        $this->percentage = $this->getNumberUtil()->convertToDouble($percentage);

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

    /**
     * Get the value of holdReceivables
     *
     * @return  int
     */
    public function getHoldReceivables()
    {
        return $this->holdReceivables;
    }

    /**
     * Set the value of holdReceivables
     *
     * @param  int  $holdReceivables
     *
     * @return  self
     */
    public function setHoldReceivables($holdReceivables = 0)
    {
        $this->holdReceivables = (int) $holdReceivables;

        return $this;
    }
}
