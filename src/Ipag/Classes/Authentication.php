<?php

namespace Ipag\Classes;

final class Authentication
{
    /**
     * @var string
     */
    private $identification;

    /**
     * @var string
     */
    private $identification2;

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
    public function getIdentification2()
    {
        return $this->identification2;
    }

    /**
     * @param string $identification2 the identification2
     */
    public function setIdentification2($identification2)
    {
        $this->identification2 = substr((string) $identification2, 0, 50);

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
}
