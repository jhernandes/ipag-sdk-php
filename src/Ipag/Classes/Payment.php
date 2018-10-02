<?php

namespace Ipag\Classes;

use Ipag\Classes\Contracts\Emptiable;
use Ipag\Classes\Contracts\ObjectSerializable;
use Ipag\Classes\Traits\EmptiableTrait;

final class Payment implements Emptiable, ObjectSerializable
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
     * @var array
     */
    private $splitRules = [];

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

    /**
     * @return array
     */
    public function getSplitRules()
    {
        return $this->splitRules;
    }

    /**
     * @param array $splitRule
     *
     * @return self
     */
    public function addSplitRule(SplitRule $splitRule)
    {
        $this->splitRules[] = $splitRule;

        return $this;
    }

    private function instructionsAreNotFull()
    {
        return (bool) (count($this->instructions) < 3);
    }

    public function serialize()
    {
        if ($this->isEmpty()) {
            throw new \Exception('É necessário informar os dados do Pagamento (Payment)');
        }

        return array_merge(
            [
                'metodo' => urlencode($this->getMethod()),
            ],
            $this->serializeInstructions(),
            $this->serializeSoftDescriptor(),
            $this->serializeSplitRules(),
            $this->getCreditCard()->serialize()
        );
    }

    private function serializeSplitRules()
    {
        $_splitRules = [];
        foreach ($this->getSplitRules() as $key => $splitRule) {
            $_splitRules["split[{$key}][seller_id]"] = urlencode($splitRule->getSellerId());
            $_splitRules["split[{$key}][percentage]"] = urlencode($splitRule->getPercentage());
            $_splitRules["split[{$key}][amount]"] = urlencode($splitRule->getAmount());
            $_splitRules["split[{$key}][liable]"] = urlencode($splitRule->getLiable());
            $_splitRules["split[{$key}][charge_processing_fee]"] = urlencode($splitRule->getChargeProcessingFee());
        }

        return $_splitRules;
    }

    private function serializeInstructions()
    {
        $_instructions = [];
        foreach ($this->getInstructions() as $key => $instruction) {
            $_instructions["instrucoes[{$key}]"] = urlencode($instruction);
        }

        return $_instructions;
    }

    private function serializeSoftDescriptor()
    {
        $_softDescriptor = [];
        $softDescriptor = $this->getSoftDescriptor();

        if (!empty($softDescriptor)) {
            $_softDescriptor['softdescriptor'] = urlencode($softDescriptor);
        }

        return $_softDescriptor;
    }
}
