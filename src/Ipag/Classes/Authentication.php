<?php

namespace Ipag\Classes;

use Ipag\Classes\Contracts\Emptiable;
use Ipag\Classes\Contracts\ObjectSerializable;
use Ipag\Classes\Traits\EmptiableTrait;

final class Authentication implements Emptiable, ObjectSerializable
{
    use EmptiableTrait;

    /**
     * @var string
     */
    private $identification;

    /**
     * @var string
     */
    private $partner;

    /**
     * @var string
     */
    private $apiKey;

    public function __construct($identification, $apiKey = null)
    {
        $this->identification = $identification;
        $this->apiKey = $apiKey;
    }

    /**
     * @return string
     */
    public function getIdentification()
    {
        return $this->identification;
    }

    /**
     * @param string $identification
     */
    public function setIdentification($identification)
    {
        $this->identification = substr((string) $identification, 0, 50);

        return $this;
    }

    /**
     * @return string
     */
    public function getPartner()
    {
        return $this->partner;
    }

    /**
     * @param string $partner
     */
    public function setPartner($partner)
    {
        $this->partner = substr((string) $partner, 0, 50);

        return $this;
    }

    /**
     * @return string
     */
    public function getApiKey()
    {
        return $this->apiKey;
    }

    /**
     * @param string $apiKey
     */
    public function setApiKey($apiKey)
    {
        $this->apiKey = $apiKey;

        return $this;
    }

    /**
     * @return bool
     */
    public function hasPartner()
    {
        return (bool) !empty($this->partner);
    }

    public function serialize()
    {
        $_user = [
            'identificacao' => urlencode($this->getIdentification()),
        ];

        if ($this->hasPartner()) {
            $_user['identificacao2'] = urlencode($this->getPartner());
        }

        return $_user;
    }
}
