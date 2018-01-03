<?php

namespace Ipag\Classes;

final class Product
{
    /**
     * @var stirng
     */
    private $name;

    /**
     * @var int
     */
    private $quantity;

    /**
     * @var float
     */
    private $unitPrice;

    /**
     * @var string
     */
    private $sku;

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return self
     */
    public function setName($name)
    {
        $this->name = substr($name, 0, 100);

        return $this;
    }

    /**
     * @return int
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @param int $quantity
     */
    public function setQuantity($quantity)
    {
        $this->quantity = (int) $quantity;

        return $this;
    }

    /**
     * @return float
     */
    public function getUnitPrice()
    {
        return $this->unitPrice;
    }

    /**
     * @param float $unitPrice
     *
     * @return self
     */
    public function setUnitPrice($unitPrice)
    {
        $this->unitPrice = Util\Number::convertToDouble($unitPrice);

        return $this;
    }

    /**
     * @return string
     */
    public function getSku()
    {
        return $this->sku;
    }

    /**
     * @param string $sku
     */
    public function setSku($sku)
    {
        $this->sku = substr($sku, 0, 20);

        return $this;
    }
}
