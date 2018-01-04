<?php

namespace Tests\Classes\Services;

use Ipag\Classes\Services\XmlService;
use PHPUnit\Framework\TestCase;

class XmlServiceTest extends TestCase
{
    private $xmlService;

    public function setUp()
    {
        parent::setUp();
        $this->xmlService = new XmlService();
    }

    public function testValidateSuccessfully()
    {
        $xml = '<?xml version="1.0" encoding="utf-8" ?>
            <retorno>
                <id_transacao>0e66639220f14eb9b4ebb59d2cb16c01</id_transacao>
                <valor>15</valor>
                <num_pedido>1521513946617</num_pedido>
                <status_pagamento>8</status_pagamento>
                <mensagem_transacao>Transação Autorizada</mensagem_transacao>
                <metodo>visa</metodo>
                <operadora>zoop</operadora>
                <operadora_mensagem>Transação autorizada</operadora_mensagem>
                <id_librepag>996327</id_librepag>
                <autorizacao_id>123456</autorizacao_id>
                <redirect>false</redirect>
                <data_pagamento>0000-00-00 00:00:00</data_pagamento>
                <num_parcela>2</num_parcela>
            </retorno>';

        $this->assertInstanceOf(\SimpleXMLElement::class, $this->xmlService->validate($xml));
    }

    public function testValidateShouldReturnFalse()
    {
        $xml = 'error';
        $this->assertFalse($this->xmlService->validate($xml));
    }
}
