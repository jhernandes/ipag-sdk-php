<?php

namespace Ipag\Classes;

use Ipag\Classes\Contracts\Emptiable;
use Ipag\Classes\Contracts\ObjectSerializable;
use Ipag\Classes\Traits\EmptiableTrait;

final class Order extends BaseResource implements Emptiable, ObjectSerializable
{
    use EmptiableTrait;

    /**
     * @var string
     */
    private $orderId;

    /**
     * @var string
     */
    private $operation;

    /**
     * @var string
     */
    private $callbackUrl;

    /**
     * @var float
     */
    private $amount;

    /**
     * @var int
     */
    private $installments;

    /**
     * @var string
     */
    private $expiry;

    /**
     * @var string
     */
    private $fingerprint;

    /**
     * @var Payment
     */
    private $payment;

    /**
     * @var Cart
     */
    private $cart;

    /**
     * @var Customer
     */
    private $customer;

    /**
     * @var Subscription
     */
    private $subscription;

    /**
     * @return string
     */
    public function getOrderId()
    {
        return $this->orderId;
    }

    /**
     * @return string
     */
    public function getOperation()
    {
        return $this->operation;
    }

    /**
     * @return string
     */
    public function getCallbackUrl()
    {
        return $this->callbackUrl;
    }

    /**
     * @return float
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @return int
     */
    public function getInstallments()
    {
        return $this->installments;
    }

    /**
     * @param string $orderId
     */
    public function setOrderId($orderId)
    {
        $this->orderId = substr((string) $orderId, 0, 20);

        return $this;
    }

    /**
     * @param string $operation
     */
    public function setOperation($operation)
    {
        $this->operation = $operation;

        return $this;
    }

    /**
     * @param string $callbackUrl
     */
    public function setCallbackUrl($callbackUrl)
    {
        $this->callbackUrl = substr((string) $callbackUrl, 0, 255);

        return $this;
    }

    /**
     * @param float $amount
     */
    public function setAmount($amount)
    {
        $this->amount = $this->getNumberUtil()->convertToDouble($amount);

        return $this;
    }

    /**
     * @param int $installments
     */
    public function setInstallments($installments)
    {
        $this->installments = $this->checkIfInstallmentsIsValidAndReturn($installments);

        return $this;
    }

    /**
     * @return string
     */
    public function getExpiry()
    {
        return $this->expiry;
    }

    /**
     * @param string $expiry
     */
    public function setExpiry($expiry)
    {
        if (!$this->getDateUtil()->isValid($expiry)) {
            throw new \UnexpectedValueException(
                'A data de vencimento não é valida ou está em formato incorreto, deve ser informada utilizando o formato dd/mm/aaaa'
            );
        }
        $this->expiry = $expiry;

        return $this;
    }

    /**
     * @return string
     */
    public function getFingerprint()
    {
        return $this->fingerprint;
    }

    /**
     * @param string $fingerprint
     */
    public function setFingerprint($fingerprint)
    {
        $this->fingerprint = substr((string) $fingerprint, 0, 120);

        return $this;
    }

    private function checkIfInstallmentsIsValidAndReturn($installments)
    {
        if (empty($installments) || $installments < 1) {
            $installments = 1;
        } elseif ($installments > 12) {
            throw new \UnexpectedValueException(
                'O parcelamento não pode ser maior que 12 (doze)'
            );
        }

        return (int) $installments;
    }

    /**
     * @return Payment
     */
    public function getPayment()
    {
        if (is_null($this->payment)) {
            $this->payment = new Payment();
        }

        return $this->payment;
    }

    /**
     * @param Payment $payment
     */
    public function setPayment(Payment $payment)
    {
        $this->payment = $payment;

        return $this;
    }

    /**
     * @return Cart
     */
    public function getCart()
    {
        if (is_null($this->cart)) {
            $this->cart = new Cart();
        }

        return $this->cart;
    }

    /**
     * @param Cart $cart
     */
    public function setCart(Cart $cart)
    {
        $this->cart = $cart;

        return $this;
    }

    /**
     * @return Customer
     */
    public function getCustomer()
    {
        if (is_null($this->customer)) {
            $this->customer = new Customer();
        }

        return $this->customer;
    }

    /**
     * @param Customer $customer
     */
    public function setCustomer(Customer $customer)
    {
        $this->customer = $customer;

        return $this;
    }

    /**
     * @return Subscription
     */
    public function getSubscription()
    {
        if (is_null($this->subscription)) {
            $this->subscription = new Subscription();
        }

        return $this->subscription;
    }

    /**
     * @param Subscription $subscription
     */
    public function setSubscription(Subscription $subscription)
    {
        $this->subscription = $subscription;

        return $this;
    }

    public function serialize()
    {
        if ($this->isEmpty()) {
            throw new \Exception('É necessário informar os dados do Pedido (Order)');
        }

        $_order = [
            'pedido'            => urlencode($this->getOrderId()),
            'operacao'          => urlencode($this->getOperation()),
            'url_retorno'       => urlencode($this->getCallbackUrl()),
            'valor'             => urlencode($this->getAmount()),
            'parcelas'          => urlencode($this->getInstallments()),
            'vencto'            => urlencode($this->getExpiry()),
            'stelo_fingerprint' => urlencode($this->getFingerprint()),
        ];

        return array_merge(
            $_order,
            $this->getPayment()->serialize(),
            $this->getCart()->serialize(),
            $this->getCustomer()->serialize(),
            $this->getSubscription()->serialize()
        );
    }
}
