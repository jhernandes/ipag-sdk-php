<?php

namespace Tests\Classes;

use Ipag\Classes\Cart;
use Ipag\Classes\Product;
use PHPUnit\Framework\TestCase;

class CartTest extends TestCase
{
    private $product;

    public function setUp()
    {
        parent::setUp();

        $this->product = new Product();
        $this->product->setName('Produto de Testes')
            ->setQuantity(10)
            ->setUnitPrice(1.99)
            ->setSku('ABCD123');
    }

    public function testCreateAndAddAProductToCart()
    {
        $cart = new Cart();

        $cart->addProduct($this->product);

        $this->assertEquals(count($cart->getProducts()), 1);
    }

    public function testCreateAndAddManyProductsToCart()
    {
        $cart = new Cart();

        $products = [
            $this->product,
            $this->product,
            $this->product,
        ];

        $cart->addProducts($products);

        $this->assertEquals(count($cart->getProducts()), 3);
    }

    public function testGetCartProductsIfItNotSetted()
    {
        $cart = new Cart();

        $this->assertEquals([], $cart->getProducts());
    }
}
