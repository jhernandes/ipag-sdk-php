<?php

namespace Ipag\Classes;

final class Cart
{
    /**
     * @var array of Product
     */
    private $products = [];

    /**
     * @return array of Product
     */
    public function getProducts()
    {
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
