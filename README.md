# iPag PHP client SDK
> A ferramenta correta para uma rápida e segura de integração com o iPag e a sua aplicação PHP

> SDK Status

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/jhernandes/ipag-sdk-php/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/jhernandes/ipag-sdk-php/?branch=master)
[![Maintainability](https://api.codeclimate.com/v1/badges/a2ca7f797ac6f1084129/maintainability)](https://codeclimate.com/github/jhernandes/ipag-sdk-php/maintainability)
[![StyleCI](https://styleci.io/repos/115621915/shield?branch=master)](https://styleci.io/repos/115621915)
[![Codacy Badge](https://api.codacy.com/project/badge/Grade/1c91d5c5f9a7465bae8ad4c3ee33f232)](https://www.codacy.com/app/jhernandes/ipag-sdk-php?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=jhernandes/ipag-sdk-php&amp;utm_campaign=Badge_Grade)
[![Codacy Badge](https://api.codacy.com/project/badge/Coverage/1c91d5c5f9a7465bae8ad4c3ee33f232)](https://www.codacy.com/app/jhernandes/ipag-sdk-php?utm_source=github.com&utm_medium=referral&utm_content=jhernandes/ipag-sdk-php&utm_campaign=Badge_Coverage)
[![Build Status](https://scrutinizer-ci.com/g/jhernandes/ipag-sdk-php/badges/build.png?b=master)](https://scrutinizer-ci.com/g/jhernandes/ipag-sdk-php/build-status/master)
---

**Índice**

- [Instalação](#instalação)
- [Autenticação](#autenticação)
    - [Por Basic Auth](#por-basic-auth)
- [Transação](#transação)
    - [Com Cartão de Crédito](#transação-com-cartão-de-crédito)
    - [Com Boleto](#transacao-com-boleto)
    - [Consulta](#consulta)
    - [Captura](#captura)
    - [Cancelamento](#cancelamento)
- [Transação com Token](#transação-com-token-one-click-buy)
    - [Criando um Token](#criando-um-token)
    - [Transacionando com Token](#transacionando-com-token)
- [Assinatura](#assinatura)
    - [Criando uma Assinatura](#criando-uma-assinatura)

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

## Transação

### Transação com Cartão de Crédito
```php
try {
    $order = $ipag->order()
        ->setOrderId($orderId)
        ->setCallbackUrl('https://minha_loja.com.br/ipag/callback')
        ->setAmount(10.00)
        ->setInstallments(1)
        ->setPayment($ipag->payment()
            ->setMethod(Method::VISA)
            ->setCreditCard($ipag->creditCard()
                ->setNumber('4066553613548107')
                ->setHolder('FULANO')
                ->setExpiryMonth('10')
                ->setExpiryYear('2025')
                ->setCvc('123')
            )
        )->setCustomer($ipag->customer()
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
        )
    );

    $response = $ipag->transaction()->setOrder($order)->execute();
} catch(\Exception $e) {
    print_r($e->__toString());
}
```
### Transação com Boleto
```php
try {
    $order = $ipag->order()
        ->setOrderId($orderId)
        ->setCallbackUrl('https://minha_loja.com.br/ipag/callback')
        ->setAmount(10.00)
        ->setInstallments(1)
        ->setExpiry('10/10/2017')
        ->setPayment($ipag->payment()
            ->setMethod(Method::BANKSLIP_ZOOP)
        )->setCustomer($ipag->customer()
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
        )
    );

    $response = $ipag->transaction()->setOrder($order)->execute();
} catch(\Exception $e) {
    print_r($e->__toString());
}
```

### Consulta

```php
$order = $ipag->order()->setCallbackUrl('https://minha_loja.com.br/ipag/callback');

$response = $ipag->transaction()->setOrder($order)->setTid('123456789')->consult();
```
### Captura

```php
$order = $ipag->order()->setCallbackUrl('https://minha_loja.com.br/ipag/callback');

$response = $ipag->transaction()->setOrder($order)->setTid('123456789')->capture();
```

### Cancelamento

```php
$order = $ipag->order()->setCallbackUrl('https://minha_loja.com.br/ipag/callback');

$response = $ipag->transaction()->setOrder($order)->setTid('123456789')->cancel();
```

## Transação com Token (One Click Buy)

### Criando um Token

```php
try {
    $order = $ipag->order()
        ->setOrderId($orderId)
        ->setCallbackUrl('https://minha_loja.com.br/ipag/callback')
        ->setAmount(10.00)
        ->setInstallments(1)
        ->setPayment($ipag->payment()
            ->setMethod(Method::VISA)
            ->setCreditCard($ipag->creditCard()
                ->setNumber('4066553613548107')
                ->setHolder('FULANO')
                ->setExpiryMonth('10')
                ->setExpiryYear('2025')
                ->setCvc('123')
                ->setSave(true) //Marca como true para gerar o token do cartão
            )
        )->setCustomer($ipag->customer()
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
        )
    );

    $response = $ipag->transaction()->setOrder($order)->execute();
} catch(\Exception $e) {
    print_r($e->__toString());
}
```

### Transacionando com Token

```php
try {
    $order = $ipag->order()
        ->setOrderId($orderId)
        ->setCallbackUrl('https://minha_loja.com.br/ipag/callback')
        ->setAmount(10.00)
        ->setInstallments(1)
        ->setPayment($ipag->payment()
            ->setMethod(Method::VISA)
            ->setCreditCard($ipag->creditCard()
                ->setToken('ABDC-ABCD-ABCD-ABDC')
            )
        )->setCustomer($ipag->customer()
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
        )
    );

    $response = $ipag->transaction()->setOrder($order)->execute();
} catch(\Exception $e) {
    print_r($e->__toString());
}
```

## Assinatura

### Criando uma Assinatura

```php
try {
    $order = $ipag->order()
        ->setOrderId($orderId)
        ->setCallbackUrl(getenv('CALLBACK_URL'))
        ->setAmount(10.00)
        ->setInstallments(1)
        ->setPayment($ipag->payment()
            ->setMethod(Method::VISA)
            ->setCreditCard($ipag->creditCard()
                ->setNumber('4066553613548107')
                ->setHolder('FULANO')
                ->setExpiryMonth('10')
                ->setExpiryYear('2025')
                ->setCvc('123')
            )
        )->setCustomer($ipag->customer()
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
            )
    )->setSubscription($ipag->subscription()
        ->setProfileId('1000000')
        ->setFrequency(1)
        ->setInterval('month')
        ->setStart('10/10/2018')
    );

    $response = $ipag->transaction()->setOrder($order)->execute();
} catch(\Exception $e) {
    print_r($e->__toString());
}
```