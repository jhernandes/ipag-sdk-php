<?php

namespace Tests\Classes\Services;

use Ipag\Classes\Services\CallbackService;
use PHPUnit\Framework\TestCase;
use stdClass;

class CallbackServiceTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->callbackService = new CallbackService();
    }

    private function xmlDummyResponse()
    {
        return '<?xml version="1.0" encoding="utf-8" ?>
            <retorno>
                <id_transacao>123456789</id_transacao>
                <valor>10.00</valor>
                <num_pedido>123456</num_pedido>
                <status_pagamento>8</status_pagamento>
                <mensagem_transacao>Transação Autorizada</mensagem_transacao>
                <metodo>visa</metodo>
                <operadora>cielo</operadora>
                <operadora_mensagem>Transação autorizada</operadora_mensagem>
                <id_librepag>12345</id_librepag>
                <autorizacao_id>123456</autorizacao_id>
                <redirect>false</redirect>
                <url_autenticacao>https://minhaloja.com.br/ipag/retorno</url_autenticacao>
            </retorno>';
    }

    public function testGetResponse()
    {
        $expected = new stdClass();
        $expected->tid = '123456789';
        $expected->amount = 10.00;

        $expected->payment = new stdClass();
        $expected->payment->status = '8';

        $response = $this->callbackService->getResponse($this->xmlDummyResponse());

        $this->assertInstanceOf('stdClass', $response);
        $this->assertEquals($expected->tid, $response->tid);
        $this->assertEquals($expected->amount, $response->amount);
        $this->assertEquals($expected->payment->status, $response->payment->status);
    }
}
