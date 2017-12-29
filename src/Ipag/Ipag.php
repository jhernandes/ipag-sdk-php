<?php

namespace Ipag;

use Ipag\Classes\Authentication;

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

    public function __construct(Authentication $authentication, $endpoint = null)
    {
        $this->authentication = $authentication;
        $this->endpoint = new Classes\Endpoint($endpoint);
    }

    public function transaction()
    {
        return new Classes\Transaction($this);
    }

    public function order()
    {
        return new Classes\Order;
    }

    public function customer()
    {
        return new Classes\Customer;
    }

    public function creditCard()
    {
        return new Classes\CreditCard;
    }

    public function address()
    {
        return new Classes\Address;
    }

    public function cart()
    {
        return new Classes\Cart;
    }

    public function payment()
    {
        return new Classes\Payment;
    }

    public function subscription()
    {
        return new Classes\Subscription;
    }

    /**
     * @return Authentication
     */
    public function getAuthentication()
    {
        return $this->authentication;
    }

    /**
     * @param Authentication $authetication
     */
    public function setAuthentication(Authentication $authetication)
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
