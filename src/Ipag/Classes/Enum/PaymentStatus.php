<?php

namespace Ipag\Classes\Enum;

abstract class PaymentStatus
{
    const CREATED = '1';
    const PRINTED_BOLETO = '2';
    const CANCELED = '3';
    const IN_ANALYSIS = '4';
    const PRE_AUTHORIZED = '5';
    const DENIED = '7';
    const CAPTURED = '8';
    const CHARGEDBACK = '9';
    const DISPUTED = '10';
}
