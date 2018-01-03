<?php

namespace Tests\Classes;

use PHPUnit\Framework\TestCase;

class ProductTest extends TestCase
{
    public function testCreateAndSetProduct()
    {
        $product = new \Ipag\Classes\Product;

        $product->setName('PRODUTO')
            ->setUnitPrice(1.99)
            ->setQuantity(10)
            ->setSku('ABDC123456789');

        $this->assertEquals('PRODUTO', $product->getName());
        $this->assertEquals(1.99, $product->getUnitPrice());
        $this->assertEquals(10, $product->getQuantity());
        $this->assertEquals('ABDC123456789', $product->getSku());
    }

    public function testCreateAndSetUnitPriceOfProduct()
    {
        $product = new \Ipag\Classes\Product;

        $product->setUnitPrice(1.99);
        $this->assertEquals(1.99, $product->getUnitPrice());

        $product->setUnitPrice('1.99');
        $this->assertEquals(1.99, $product->getUnitPrice());

        $product->setUnitPrice('1,99');
        $this->assertEquals(1.99, $product->getUnitPrice());

    }
}
