<?php

namespace Ipag\Classes\Enum;

abstract class Action
{
    const PAYMENT = 'payment';
    const CONSULT = 'consult';
    const CAPTURE = 'capture';
    const CANCEL = 'cancel';
}
