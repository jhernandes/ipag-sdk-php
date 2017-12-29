<?php

namespace Ipag\Classes\Serializer;

use Ipag\Classes\Transaction;

final class ConsultSerializer implements Serializer
{
    public function serialize(Transaction $transaction)
    {
        return array(
            'identificacao' => urlencode($transaction->getUser()->getIdentification()),
            'transId' => urlencode($transaction->getTid()),
            'url_retorno' => urlencode($transaction->getOrder()->getCallbackUrl()),
            'retorno_tipo' => urlencode('xml'),
        );
    }
}
