<?php

namespace Tests\Classes;

use PHPUnit\Framework\TestCase;

class CartTest extends TestCase
{
    private $product;

    public function setUp()
    {
        parent::setUp();

        $this->product = new \Ipag\Classes\Product();
        $this->product->setName('Produto de Testes')
            ->setQuantity(10)
            ->setUnitPrice(1.99)
            ->setSku('ABCD123');
    }

    public function testCreateAndAddAProductToCart()
    {
        $cart = new \Ipag\Classes\Cart();

        $cart->addProduct($this->product);

        $this->assertEquals(count($cart->getProducts()), 1);
    }

    public function testCreateAndAddManyProductsToCart()
    {
        $cart = new \Ipag\Classes\Cart();

        $products = [
            $this->product,
            $this->product,
            $this->product,
        ];

        $cart->addProducts($products);

        $this->assertEquals(count($cart->getProducts()), 3);
    }
}
