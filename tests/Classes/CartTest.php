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

        $cart->addProducts(
            ['Produto 1', 5.00, 1, 'ABCD98827'],
            ['Produto 2', 10.00, 6, 'ABCD98828'],
            ['Produto 3', 1.00, 2, 'ABCD98829']
        );

        $this->assertEquals(count($cart->getProducts()), 3);
    }

    public function testGetCartProductsIfItNotSetted()
    {
        $cart = new Cart();

        $this->assertEquals([], $cart->getProducts());
    }
}
