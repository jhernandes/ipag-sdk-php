# iPag PHP client SDK
> A ferramenta certa para uma rápida e segura integração com o iPag e a sua aplicação PHP

> SDK Status

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/jhernandes/ipag-sdk-php/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/jhernandes/ipag-sdk-php/?branch=master)
[![Maintainability](https://api.codeclimate.com/v1/badges/a2ca7f797ac6f1084129/maintainability)](https://codeclimate.com/github/jhernandes/ipag-sdk-php/maintainability)
[![StyleCI](https://styleci.io/repos/115621915/shield?branch=master)](https://styleci.io/repos/115621915)
[![Codacy Badge](https://api.codacy.com/project/badge/Grade/1c91d5c5f9a7465bae8ad4c3ee33f232)](https://www.codacy.com/app/jhernandes/ipag-sdk-php?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=jhernandes/ipag-sdk-php&amp;utm_campaign=Badge_Grade)
[![Codacy Badge](https://api.codacy.com/project/badge/Coverage/1c91d5c5f9a7465bae8ad4c3ee33f232)](https://www.codacy.com/app/jhernandes/ipag-sdk-php?utm_source=github.com&utm_medium=referral&utm_content=jhernandes/ipag-sdk-php&utm_campaign=Badge_Coverage)
[![Build Status](https://scrutinizer-ci.com/g/jhernandes/ipag-sdk-php/badges/build.png?b=master)](https://scrutinizer-ci.com/g/jhernandes/ipag-sdk-php/build-status/master)
---

**Índice**

- [Dependências](#dependências)
- [Instalação](#instalação)
- [Autenticação](#autenticação)
    - [Por Basic Auth](#por-basic-auth)
- [Cliente](#cliente)
    - [Dados do Cliente](#dados-do-cliente)
- [Cartão de Crédito/Débito](#cartão-de-crédito/débito)
    - [Dados do Cartão de Crédito/Débito](#dados-do-cartão-de-crédito/débito)
- [Transação](#transação)
    - [Com Cartão de Crédito](#transação-com-cartão-de-crédito)
    - [Com Token de Cartão de Crédito](#transação-com-token-de-cartão-de-crédito)
    - [Com Boleto](#transacao-com-boleto)
    - [Consulta](#consulta)
    - [Captura](#captura)
    - [Cancelamento](#cancelamento)
- [Assinatura](#assinatura)
    - [Criando uma Assinatura](#criando-uma-assinatura)
- [Exemplo de Transação Completa](#exemplo-de-transação-completa)
- [Testes](#testes)
- [Licença](#licença)
- [Documentação](#documentação)
- [Dúvidas & Sugestões](#duvidas-&-sugestões)

## Dependências
require
    * PHP >= 5.6
require-dev
    * phpunit/phpunit
    * codacy/coverage

## Instalação

Execute em seu shell:

    composer require jhernandes/ipag-sdk-php

## Autenticação
### Por Basic Auth

```php
require 'vendor/autoload.php';

use Ipag\Ipag;
use Ipag\Classes\Authentication;
use Ipag\Classes\Endpoint;

$ipag = new Ipag(new Authentication('my_id_ipag', 'my_ipag_key'), Endpoint::SANDBOX);
```
## Cliente
### Dados do Cliente

```php
$customer = $ipag->customer()
    ->setName('Fulano da Silva')
    ->setTaxpayerId('799.993.388-01')
    ->setPhone('11', '98888-3333')
    ->setEmail('fulanodasilva@gmail.com')
    ->setAddress($ipag->address()
        ->setStreet('Rua Júlio Gonzalez')
        ->setNumber('1000')
        ->setNeighborhood('Barra Funda')
        ->setCity('São Paulo')
        ->setState('SP')
        ->setZipCode('01156-060')
);
```

## Cartão de Crédito/Débito
### Dados do Cartão de Crédito/Débito

```php
$creditCard = $ipag->creditCard()
    ->setNumber('4066553613548107')
    ->setHolder('FULANO')
    ->setExpiryMonth('10')
    ->setExpiryYear('2025')
    ->setCvc('123')
    ->setSave(true); //True para gerar o token do cartão (one-click-buy)
```
## Transação (Pagamento)
### Transação com Cartão de Crédito
```php
$ipag->transaction()->getOrder()
    ->setOrderId($orderId)
    ->setCallbackUrl('https://minha_loja.com.br/ipag/callback')
    ->setAmount(10.00)
    ->setInstallments(1)
    ->setPayment($ipag->payment()
        ->setMethod(Method::VISA)
        ->setCreditCard($creditCard)
    )->setCustomer($customer)
);

$response = $ipag->transaction()->execute();
```

### Transação com Token de Cartão de Crédito
```php
$ipag->transaction()->getOrder()
    ->setOrderId($orderId)
    ->setCallbackUrl('https://minha_loja.com.br/ipag/callback')
    ->setAmount(10.00)
    ->setInstallments(1)
    ->setPayment($ipag->payment()
        ->setMethod(Method::VISA)
        ->setCreditCard($ipag->creditCard()
            ->setToken('ABDC-ABCD-ABCD-ABDC')
        )
    )->setCustomer($customer)
);

$response = $ipag->transaction()->execute();
```

### Transação com Boleto
```php
$ipag->transaction()->getOrder()
    ->setOrderId($orderId)
    ->setCallbackUrl('https://minha_loja.com.br/ipag/callback')
    ->setAmount(10.00)
    ->setInstallments(1)
    ->setExpiry('10/10/2017')
    ->setPayment($ipag->payment()
        ->setMethod(Method::BANKSLIP_ZOOP)
    )->setCustomer($customer)
);

$response = $ipag->transaction()->execute();
```

### Consulta

```php
$response = $ipag->transaction()->setTid('123456789')->consult();
```
### Captura

```php
$response = $ipag->transaction()->setTid('123456789')->capture();
```

### Cancelamento

```php
$response = $ipag->transaction()->setTid('123456789')->cancel();
```

## Assinatura
### Criando uma Assinatura

```php
$ipag->transaction()->getOrder()
    ->setOrderId($orderId)
    ->setCallbackUrl(getenv('CALLBACK_URL'))
    ->setAmount(10.00)
    ->setInstallments(1)
    ->setPayment($ipag->payment()
        ->setMethod(Method::VISA)
        ->setCreditCard($creditCard)
    )->setCustomer($customer)
)->setSubscription($ipag->subscription()
    ->setProfileId('1000000')
    ->setFrequency(1)
    ->setInterval('month')
    ->setStart('10/10/2018')
);

$response = $ipag->transaction()->execute();
```

## Exemplo de Transação Completa
### Exemplo via Cartão de Crédito

```php
<?php

require 'vendor/autoload.php';

use Ipag\Ipag;
use Ipag\Classes\Authentication;
use Ipag\Classes\Endpoint;

try {
    $ipag = new Ipag(new Authentication('my_id_ipag', 'my_ipag_key'), Endpoint::SANDBOX);

    $customer = $ipag->customer()
        ->setName('Fulano da Silva')
        ->setTaxpayerId('799.993.388-01')
        ->setPhone('11', '98888-3333')
        ->setEmail('fulanodasilva@gmail.com')
        ->setAddress($ipag->address()
            ->setStreet('Rua Júlio Gonzalez')
            ->setNumber('1000')
            ->setNeighborhood('Barra Funda')
            ->setCity('São Paulo')
            ->setState('SP')
            ->setZipCode('01156-060')
    );

    $creditCard = $ipag->creditCard()
        ->setNumber('4066553613548107')
        ->setHolder('FULANO')
        ->setExpiryMonth('10')
        ->setExpiryYear('2025')
        ->setCvc('123');

    $ipag->transaction()->getOrder()
        ->setOrderId($orderId)
        ->setCallbackUrl('https://minha_loja.com.br/ipag/callback')
        ->setAmount(10.00)
        ->setInstallments(1)
        ->setPayment($ipag->payment()
            ->setMethod(Method::VISA)
            ->setCreditCard($creditCard)
        )
        ->setCustomer($customer);

    $response = $ipag->transaction()->execute();

    //Retornou algum erro?
    if (!empty($response->error)) {
        throw new \Exception($response->errorMessage);
    }

    //Pagamento Aprovado (5) ou Aprovado e Capturado(8) ?
    if ($response->payment->status == '5' || $response->payment->status == '8') {
        //Faz alguma coisa...
        return $response;
    }
} catch(\Exception $e) {
    print_r($e->__toString());
}
```

## Testes

Os Tests Unitários são realizados contra o Sandbox do iPag, o arquivo de configuração (phpunit.xml) já vem preenchido com um acesso limitado ao Sandbox.

É necessário a instalação do PHPUnit para a realização dos testes.

## Licença
[The MIT License](https://github.com/jhernandes/ipag-sdk-php/blob/master/LICENSE)

## Documentação

[Documentação Oficial](https://docs.ipag.com.br)

## Dúvidas & Sugestões

Em caso de dúvida ou sugestão para o SDK abra uma nova [Issue](https://github.com/jhernandes/ipag-sdk-php/issues).
