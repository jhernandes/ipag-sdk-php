<?php

namespace Ipag;

use Ipag\Classes\Authentication;
use Ipag\Classes\Endpoint;

class Ipag
{
    /**
     * @var Endpoint
     */
    private $endpoint;

    /**
     * @var Authentication
     */
    private $authentication;

    public function __construct(Authentication $authentication, $url = null)
    {
        $this->authentication = $authentication;
        $this->endpoint = new Classes\Endpoint($url);
    }

    public function transaction()
    {
        return new Classes\Transaction($this);
    }

    public function order()
    {
        return new Classes\Order();
    }

    public function customer()
    {
        return new Classes\Customer();
    }

    public function creditCard()
    {
        return new Classes\CreditCard();
    }

    public function address()
    {
        return new Classes\Address();
    }

    public function cart(array...$products)
    {
        return new Classes\Cart(...$products);
    }

    public function product()
    {
        return new Classes\Product();
    }

    public function payment()
    {
        return new Classes\Payment();
    }

    public function subscription()
    {
        return new Classes\Subscription();
    }

    public function splitRule()
    {
        return new Classes\SplitRule();
    }

    /**
     * @return Authentication
     */
    public function getAuthentication()
    {
        return $this->authentication;
    }

    /**
     * @param Authentication $authentication
     */
    public function setAuthentication(Authentication $authentication)
    {
        $this->authentication = $authentication;

        return $this;
    }

    /**
     * @return Endpoint
     */
    public function getEndpoint()
    {
        return $this->endpoint;
    }

    /**
     * @param Endpoint $endpoint
     */
    public function setEndpoint(Endpoint $endpoint)
    {
        $this->endpoint = $endpoint;

        return $this;
    }
}
