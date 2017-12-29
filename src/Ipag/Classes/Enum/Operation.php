<?php

namespace Ipag\Classes\Enum;

abstract class Operation
{
    const PAYMENT = 'Pagamento';
    const CONSULT = 'Consulta';
    const CAPTURE = 'Captura';
    const CANCEL = 'Cancela';
}
