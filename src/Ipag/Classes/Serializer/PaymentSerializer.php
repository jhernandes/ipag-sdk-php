<?php

namespace Ipag\Classes\Serializer;

use Ipag\Classes\Contracts\Serializable;
use Ipag\Classes\Transaction;

final class PaymentSerializer extends Serializer implements Serializable
{
    public function serialize()
    {
        $_returnType = [
            'retorno_tipo' => urlencode('xml'),
            'boleto_tipo'  => urlencode('xml'),
        ];

        $_user = $this->transaction->getIpag()->getAuthentication()->serialize();
        $_order = $this->transaction->getOrder()->serialize();

        return array_merge($_returnType, $_user, $_order);
    }
}
