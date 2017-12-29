<?php

namespace Ipag\Classes;

final class Order
{
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
     * @var double
     */
    private $amount;

    /**
     * @var int
     */
    private $installments = 1;

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
     * Get the value of Amount
     *
     * @return double
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Get the value of Installments
     *
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
     * @param double $amount
     */
    public function setAmount($amount)
    {
        $this->amount = Util\Number::convertToDouble($amount);

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
        if (!$this->isValidExpiryFormatDate($expiry)) {
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
        if ($installments < 1) {
            $installments = 1;
        } elseif ($installments > 12) {
            $installments = 12;
        }

        return (int) $installments;
    }

    private function isValidExpiryFormatDate($date)
    {
        if (preg_match("/([0-9]{2})\/([0-9]{2})\/([0-9]{4})/", $date, $matches)) {
            if (checkdate($matches[2], $matches[1], $matches[3])) {
                return true;
            }
        }
        return false;
    }

    /**
     * @return Payment
     */
    public function getPayment()
    {
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
}
