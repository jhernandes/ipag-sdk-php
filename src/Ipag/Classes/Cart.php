<?php

namespace Ipag\Classes;

use Ipag\Classes\Contracts\Emptiable;
use Ipag\Classes\Contracts\ObjectSerializable;
use Ipag\Classes\Traits\EmptiableTrait;

final class Cart implements Emptiable, ObjectSerializable
{
    use EmptiableTrait;

    /**
     * @var array
     */
    private $products = [];

    public function __construct(array ...$products)
    {
        $this->addProducts(...$products);
    }

    /**
     * @return array
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
     * @param array
     */
    public function addProducts(array ...$products)
    {
        foreach ($products as $product) {
            if (!empty($product)) {
                $this->addProduct((new Product())
                        ->setName(isset($product[0]) ? preg_replace('/[^0-9a-zA-Z ]/', '', $product[0]) : '')
                        ->setUnitPrice(isset($product[1]) ? $product[1] : 0)
                        ->setQuantity(isset($product[2]) ? $product[2] : 1)
                        ->setSku(isset($product[3]) ? $product[3] : '')
                );
            }
        }

        return $this;
    }

    public function serialize()
    {
        if ($this->isEmpty()) {
            return [];
        }

        return [
            'descricao_pedido' => urlencode(json_encode($this->serializeProducts())),
        ];
    }

    private function serializeProducts()
    {
        $_products = [];
        $productId = 1;

        foreach ($this->getProducts() as $product) {
            $_products[$productId++] = [
                'descr' => $product->getName(),
                'valor' => $product->getUnitPrice(),
                'quant' => $product->getQuantity(),
                'id'    => $product->getSku(),
            ];
        }

        return $_products;
    }
}
