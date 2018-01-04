<?php

namespace Ipag\Classes;

use Ipag\Classes\Contracts\Emptiable;
use Ipag\Classes\Traits\EmptiableTrait;

final class Cart implements Emptiable
{
    use EmptiableTrait;

    /**
     * @var array of Product
     */
    private $products = [];

    /**
     * @return array of Product
     */
    public function getProducts()
    {
        if (empty($this->products)) {
            return [];
        }

        return $this->products;
    }

    /**
     * @param Product $product
     */
    public function addProduct(Product $product)
    {
        $this->products[] = $product;

        return $this;
    }

    /**
     * @param array of Product $products
     */
    public function addProducts(array $products)
    {
        foreach ($products as $product) {
            $this->addProduct($product);
        }

        return $this;
    }
}
