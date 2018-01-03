<?php

namespace Ipag\Classes\Serializer;

use Ipag\Classes\Transaction;

final class CaptureSerializer implements Serializer
{
    /**
     * @var Transaction
     */
    private $transaction;

    public function __construct(Transaction $transaction)
    {
        $this->transaction = $transaction;
    }

    public function serialize()
    {
        return [
            'identificacao' => urlencode($this->transaction->getIpag()->getAuthentication()->getIdentification()),
            'transId'       => urlencode($this->transaction->getTid()),
            'url_retorno'   => urlencode($this->transaction->getOrder()->getCallbackUrl()),
            'retorno_tipo'  => urlencode('xml'),
        ];
    }
}
