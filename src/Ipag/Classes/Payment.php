<?php

namespace Ipag\Classes;

use Ipag\Classes\Contracts\Emptiable;
use Ipag\Classes\Traits\EmptiableTrait;

final class Payment implements Emptiable
{
    use EmptiableTrait;

    /**
     * @var string
     */
    private $method;

    /**
     * @var CreditCard
     */
    private $creditCard;

    /**
     * @var array
     */
    private $instructions = [];

    /**
     * @var string
     */
    private $softDescriptor;

    /**
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @return CreditCard
     */
    public function getCreditCard()
    {
        if (is_null($this->creditCard)) {
            $this->creditCard = new CreditCard();
        }

        return $this->creditCard;
    }

    /**
     * @param string $method
     */
    public function setMethod($method)
    {
        $this->method = $method;

        return $this;
    }

    /**
     * @param CreditCard $creditCard
     */
    public function setCreditCard(CreditCard $creditCard)
    {
        $this->creditCard = $creditCard;

        return $this;
    }

    /**
     * @return array
     */
    public function getInstructions()
    {
        return $this->instructions;
    }

    /**
     * @param string $instructions
     */
    public function setInstructions($instructions)
    {
        if ($this->instructionsAreNotFull()) {
            $this->instructions[] = substr($instructions, 0, 80);
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getSoftDescriptor()
    {
        return $this->softDescriptor;
    }

    /**
     * @param string $softDescriptor
     */
    public function setSoftDescriptor($softDescriptor)
    {
        $this->softDescriptor = substr($softDescriptor, 0, 22);

        return $this;
    }

    private function instructionsAreNotFull()
    {
        return (bool) (count($this->instructions) < 3);
    }
}
