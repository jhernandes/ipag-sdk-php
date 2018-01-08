<?php

namespace Ipag\Classes\Contracts;

use Ipag\Classes\Transaction;

interface Serializable
{
    /**
     * @return array
     */
    public function serialize();

    /**
     * @return Transaction
     */
    public function getTransaction();

    /**
     * @return string
     */
    public function getAction();

    /**
     * @return string
     */
    public function getOperation();
}
