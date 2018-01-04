<?php

namespace Tests\Classes\Services;

use Ipag\Classes\Authentication;
use Ipag\Classes\Enum\Method;
use Ipag\Classes\Serializer\PaymentSerializer;
use Ipag\Ipag;
use PHPUnit\Framework\TestCase;

class PaymentSerializerTest extends TestCase
{
    private $ipag;
    private $customer;

    public function setUp()
    {
        parent::setUp();

        $authentication = new Authentication('app@test.com');

        $this->ipag = new Ipag($authentication);

        $this->customer = $this->ipag->customer()
            ->setName('Fulano da Silva')
            ->setTaxpayerId('799.993.388-01')
            ->setPhone('11', '98888-3333')
            ->setEmail('fulanodasilva@gmail.com')
            ->setAddress($this->ipag->address()
                    ->setStreet('Rua Júlio Gonzalez')
                    ->setNumber('1000')
                    ->setNeighborhood('Barra Funda')
                    ->setCity('São Paulo')
                    ->setState('SP')
                    ->setZipCode('01156-060')
            );
    }

    public function testSerializeWithFullCreditCard()
    {
        $this->ipag->getAuthentication()->setIdentification2('partner@test.com');

        $transaction = $this->ipag->transaction();
        $transaction->getOrder()
            ->setOrderId('10000')
            ->setCallbackUrl('https://minha_loja.com.br/ipag/callback')
            ->setAmount(10.00)
            ->setInstallments(1)
            ->setPayment($this->ipag->payment()
                    ->setMethod(Method::VISA)
                    ->setCreditCard($this->ipag->creditCard()
                            ->setNumber('4066553613548107')
                            ->setHolder('FULANO')
                            ->setExpiryMonth('10')
                            ->setExpiryYear('2025')
                            ->setCvc('123')
                            ->setSave(true)
                    )->setInstructions('Instrução 1')
                    ->setInstructions('Instrução 2')
                    ->setInstructions('Instrução 3')
                    ->setSoftDescriptor('EMPRESA')
            )->setCustomer($this->customer)
            ->setCart($this->ipag->cart()
                    ->addProduct($this->ipag->product()
                            ->setName('Produto 1')
                            ->setQuantity(2)
                            ->setUnitPrice(1.00)
                            ->setSku('G9F07GSD96FA8')
                    )
            );

        $paymentSerializer = new PaymentSerializer($transaction);

        $response = $paymentSerializer->serialize();

        $expected = [
            'identificacao'     => 'app%40test.com',
            'identificacao2'    => 'partner%40test.com',
            'url_retorno'       => 'https%3A%2F%2Fminha_loja.com.br%2Fipag%2Fcallback',
            'retorno_tipo'      => 'xml',
            'boleto_tipo'       => 'xml',
            'pedido'            => '10000',
            'operacao'          => '',
            'valor'             => '10',
            'parcelas'          => '1',
            'vencto'            => '',
            'stelo_fingerprint' => '',
            'metodo'            => 'visa',
            'num_cartao'        => '4066553613548107',
            'nome_cartao'       => 'FULANO',
            'mes_cartao'        => '10',
            'ano_cartao'        => '2025',
            'cvv_cartao'        => '123',
            'gera_token_cartao' => '1',
            'nome'              => 'Fulano+da+Silva',
            'email'             => 'fulanodasilva%40gmail.com',
            'doc'               => '79999338801',
            'fone'              => '11988883333',
            'endereco'          => 'Rua+J%C3%BAlio+Gonzalez',
            'numero_endereco'   => '1000',
            'complemento'       => '',
            'bairro'            => 'Barra+Funda',
            'cidade'            => 'S%C3%A3o+Paulo',
            'estado'            => 'SP',
            'pais'              => 'BR',
            'cep'               => '01156060',
            'instrucoes[0]'     => 'Instru%C3%A7%C3%A3o+1',
            'instrucoes[1]'     => 'Instru%C3%A7%C3%A3o+2',
            'instrucoes[2]'     => 'Instru%C3%A7%C3%A3o+3',
            'softdescriptor'    => 'EMPRESA',
            'descricao_pedido'  => '%7B%221%22%3A%7B%22descr%22%3A%22Produto+1%22%2C%22valor%22%3A1%2C%22quant%22%3A2%2C%22id%22%3A%22G9F07GSD96FA8%22%7D%7D',
        ];

        $this->assertEquals($expected, $response);
    }

    public function testSerializeWithCreditCardToken()
    {
        $transaction = $this->ipag->transaction();
        $transaction->getOrder()
            ->setOrderId('10000')
            ->setCallbackUrl('https://minha_loja.com.br/ipag/callback')
            ->setAmount(10.00)
            ->setInstallments(1)
            ->setPayment($this->ipag->payment()
                    ->setMethod(Method::VISA)
                    ->setCreditCard($this->ipag->creditCard()
                            ->setToken('123456789')
                    )
            )->setCustomer($this->customer);

        $paymentSerializer = new PaymentSerializer($transaction);

        $response = $paymentSerializer->serialize();

        $expected = [
            'identificacao'     => 'app%40test.com',
            'url_retorno'       => 'https%3A%2F%2Fminha_loja.com.br%2Fipag%2Fcallback',
            'retorno_tipo'      => 'xml',
            'boleto_tipo'       => 'xml',
            'pedido'            => '10000',
            'operacao'          => '',
            'valor'             => '10',
            'parcelas'          => '1',
            'vencto'            => '',
            'stelo_fingerprint' => '',
            'metodo'            => 'visa',
            'token_cartao'      => '123456789',
            'nome'              => 'Fulano+da+Silva',
            'email'             => 'fulanodasilva%40gmail.com',
            'doc'               => '79999338801',
            'fone'              => '11988883333',
            'endereco'          => 'Rua+J%C3%BAlio+Gonzalez',
            'numero_endereco'   => '1000',
            'complemento'       => '',
            'bairro'            => 'Barra+Funda',
            'cidade'            => 'S%C3%A3o+Paulo',
            'estado'            => 'SP',
            'pais'              => 'BR',
            'cep'               => '01156060',
        ];

        $this->assertEquals($expected, $response);
    }

    public function testSerializeWithoutCustomer()
    {
        $transaction = $this->ipag->transaction();
        $transaction->getOrder()
            ->setOrderId('10000')
            ->setCallbackUrl('https://minha_loja.com.br/ipag/callback')
            ->setAmount(10.00)
            ->setInstallments(1)
            ->setPayment($this->ipag->payment()
                    ->setMethod(Method::VISA)
                    ->setCreditCard($this->ipag->creditCard()
                            ->setToken('123456789')
                    )
            );

        $paymentSerializer = new PaymentSerializer($transaction);

        $response = $paymentSerializer->serialize();

        $expected = [
            'identificacao'     => 'app%40test.com',
            'url_retorno'       => 'https%3A%2F%2Fminha_loja.com.br%2Fipag%2Fcallback',
            'retorno_tipo'      => 'xml',
            'boleto_tipo'       => 'xml',
            'pedido'            => '10000',
            'operacao'          => '',
            'valor'             => '10',
            'parcelas'          => '1',
            'vencto'            => '',
            'stelo_fingerprint' => '',
            'metodo'            => 'visa',
            'token_cartao'      => '123456789',
        ];

        $this->assertEquals($expected, $response);
    }

    public function testSerializeWithoutCustomerAddress()
    {
        $transaction = $this->ipag->transaction();
        $transaction->getOrder()
            ->setOrderId('10000')
            ->setCallbackUrl('https://minha_loja.com.br/ipag/callback')
            ->setAmount(10.00)
            ->setInstallments(1)
            ->setPayment($this->ipag->payment()
                    ->setMethod(Method::VISA)
                    ->setCreditCard($this->ipag->creditCard()
                            ->setToken('123456789')
                    )
            )->setCustomer($this->ipag->customer()
                ->setName('Fulano da Silva')
                ->setTaxpayerId('799.993.388-01')
                ->setPhone('11', '98888-3333')
                ->setEmail('fulanodasilva@gmail.com'));

        $paymentSerializer = new PaymentSerializer($transaction);

        $response = $paymentSerializer->serialize();

        $expected = [
            'identificacao'     => 'app%40test.com',
            'url_retorno'       => 'https%3A%2F%2Fminha_loja.com.br%2Fipag%2Fcallback',
            'retorno_tipo'      => 'xml',
            'boleto_tipo'       => 'xml',
            'pedido'            => '10000',
            'operacao'          => '',
            'valor'             => '10',
            'parcelas'          => '1',
            'vencto'            => '',
            'stelo_fingerprint' => '',
            'metodo'            => 'visa',
            'token_cartao'      => '123456789',
            'nome'              => 'Fulano+da+Silva',
            'email'             => 'fulanodasilva%40gmail.com',
            'doc'               => '79999338801',
            'fone'              => '11988883333',
        ];

        $this->assertEquals($expected, $response);
    }

    public function testSerializeWithoutOrderShouldThrowException()
    {
        $this->expectException(\Exception::class);

        $paymentSerializer = new PaymentSerializer($this->ipag->transaction());

        $paymentSerializer->serialize();
    }

    public function testSerializeWithoutPaymentShouldThrowException()
    {
        $this->expectException(\Exception::class);

        $transaction = $this->ipag->transaction();
        $transaction->getOrder()
            ->setOrderId('10000')
            ->setCallbackUrl('https://minha_loja.com.br/ipag/callback')
            ->setAmount(10.00)
            ->setInstallments(1);

        $paymentSerializer = new PaymentSerializer($transaction);

        $paymentSerializer->serialize();
    }

    public function testSerializeBoletoPayment()
    {
        $transaction = $this->ipag->transaction();
        $transaction->getOrder()
            ->setOrderId('10000')
            ->setCallbackUrl('https://minha_loja.com.br/ipag/callback')
            ->setAmount(10.00)
            ->setInstallments(1)
            ->setPayment($this->ipag->payment()
                    ->setMethod(Method::BANKSLIP_ITAU)
            )->setCustomer($this->customer);

        $paymentSerializer = new PaymentSerializer($transaction);

        $response = $paymentSerializer->serialize();

        $expected = [
            'identificacao'     => 'app%40test.com',
            'url_retorno'       => 'https%3A%2F%2Fminha_loja.com.br%2Fipag%2Fcallback',
            'retorno_tipo'      => 'xml',
            'boleto_tipo'       => 'xml',
            'pedido'            => '10000',
            'operacao'          => '',
            'valor'             => '10',
            'parcelas'          => '1',
            'vencto'            => '',
            'stelo_fingerprint' => '',
            'metodo'            => 'boleto_itau',
            'nome'              => 'Fulano+da+Silva',
            'email'             => 'fulanodasilva%40gmail.com',
            'doc'               => '79999338801',
            'fone'              => '11988883333',
            'endereco'          => 'Rua+J%C3%BAlio+Gonzalez',
            'numero_endereco'   => '1000',
            'complemento'       => '',
            'bairro'            => 'Barra+Funda',
            'cidade'            => 'S%C3%A3o+Paulo',
            'estado'            => 'SP',
            'pais'              => 'BR',
            'cep'               => '01156060',
        ];

        $this->assertEquals($expected, $response);
    }

    public function testSerializeWithSubscription()
    {
        $transaction = $this->ipag->transaction();
        $transaction->getOrder()
            ->setOrderId('10000')
            ->setCallbackUrl('https://minha_loja.com.br/ipag/callback')
            ->setAmount(10.00)
            ->setInstallments(1)
            ->setPayment($this->ipag->payment()
                    ->setMethod(Method::VISA)
                    ->setCreditCard($this->ipag->creditCard()
                            ->setToken('123456789')
                    )
            )->setCustomer($this->customer)
            ->setSubscription($this->ipag->subscription()
                    ->setFrequency(1)
                    ->setInterval('month')
            );

        $paymentSerializer = new PaymentSerializer($transaction);

        $response = $paymentSerializer->serialize();

        $expected = [
            'identificacao'     => 'app%40test.com',
            'url_retorno'       => 'https%3A%2F%2Fminha_loja.com.br%2Fipag%2Fcallback',
            'retorno_tipo'      => 'xml',
            'boleto_tipo'       => 'xml',
            'pedido'            => '10000',
            'operacao'          => '',
            'valor'             => '10',
            'parcelas'          => '1',
            'vencto'            => '',
            'stelo_fingerprint' => '',
            'metodo'            => 'visa',
            'token_cartao'      => '123456789',
            'nome'              => 'Fulano+da+Silva',
            'email'             => 'fulanodasilva%40gmail.com',
            'doc'               => '79999338801',
            'fone'              => '11988883333',
            'endereco'          => 'Rua+J%C3%BAlio+Gonzalez',
            'numero_endereco'   => '1000',
            'complemento'       => '',
            'bairro'            => 'Barra+Funda',
            'cidade'            => 'S%C3%A3o+Paulo',
            'estado'            => 'SP',
            'pais'              => 'BR',
            'cep'               => '01156060',
            'profile_id'        => '',
            'frequencia'        => '1',
            'intervalo'         => 'month',
            'inicio'            => '',
            'ciclos'            => '',
            'valor_rec'         => '',
            'trial'             => '',
            'trial_ciclos'      => '',
            'trial_frequencia'  => '',
            'trial_valor'       => '',
        ];

        $this->assertEquals($expected, $response);
    }

    public function testSerializePaymentWithEmptyOrder()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('É necessário informar os dados do Pedido (Order)');

        $transaction = $this->ipag->transaction();

        $paymentSerializer = new PaymentSerializer($transaction);

        $paymentSerializer->serialize();
    }
}
