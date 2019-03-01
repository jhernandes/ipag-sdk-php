<?php

namespace Tests;

use Ipag\Classes\Authentication;
use Ipag\Classes\Endpoint;
use Ipag\Classes\Enum\Method;
use Ipag\Classes\SplitRule;
use Ipag\Classes\Subscription;
use Ipag\Ipag;
use PHPUnit\Framework\TestCase;

class PaymentTest extends TestCase
{
    private $transaction;
    private $ipag;

    public function __construct()
    {
        parent::__construct();
        $this->init();
    }

    public function setUp()
    {
        parent::setUp();
        $this->init();
    }

    public function init()
    {
        $this->ipag = new Ipag(new Authentication(getenv('ID_IPAG'), getenv('API_KEY')), Endpoint::SANDBOX);

        $this->transaction = $this->ipag->transaction();

        $cart = $this->ipag->cart(
            ['APC Flotador Universal Perol 5 Litros', 55.9, 2, '000347'],
            ['Aplicador de gel para pneus Cadillac', 10, 2, '001567'],
            ['Escova Azul para Furo de Rodas Mandala', 35.9, 2, 'E01'],
            ['Polidor de Corte LPD Hi Cut + Lincoln 1K (nova fórmula)', 148.9, 1, '002053'],
            ['Lava Auto Shampoo Super Concentrado 1:300 Monster Cadillac 2L', 37.05, 2, '001646'],
            ['Balde com Protetor de Areia Ultimate Filter GF', 60.9, 1, '001549'],
            ['Balde com Protetor de Areia Ultimate Filter GF', 60.9, 1, '001549'],
            ['Removedor de Piche Tar Remover Sonax 300ml', 54, 1, '000586'],
            ['Boina de Espuma Super Macia Preta Waffle Mills 7.8\'', 60, 1, '001004'],
            ['Cera de Carnaúba Cleaner Wax Cadillac 300gr', 79.9, 1, '000312'],
            ['Cera de Carnaúba Lincoln 200g', 72.5, 1, '001051'],
            ['Vonixx Cera de Carnaúba Super Protetora', 52, 1, '001455'],
            ['Vonixx Revitalizador de Pneus 500ml', 32, 1, '001479'],
            ['Boina de Espuma Médio Agressiva Dune Alcance 5\' ', 41.5, 1, '002333'],
            ['Boina Lã S/Interface Corte Lincoln 6\' (listra Colorida)', 39, 1, '001891'],
            ['Desinfetante BAC 500 Perol 5L', 66.9, 1, '001286'],
            ['Escova Caixa de Roda Cadillac', 39.9, 1, '000544'],
            ['Escova para Estofados (cerdas de silicone) Cadillac', 36.9, 1, '001488'],
            ['Lavagem a Seco Affix Perol 5L', 216.9, 1, '000499'],
            ['POLIDOR DE METAIS METAL-LAC CADILLAC 150G', 37.9, 1, '831676'],
            ['Vonixx Restaurax 500ml', 32.9, 1, '001478'],
            ['Revitalizador de Plásticos Doctor Shine Cadillac 500ml', 34.1, 1, '002020'],
            ['Menzerna Selante Power Lock Ultimate Protection 1L', 251.9, 1, '001423'],
            ['Pneu Visco Cadillac 5L', 43.6, 1, '000265'],
            ['Metal Polish Optimum 227g', 83, 1, '001910'],
            ['Nano Pro (Profiline) Perfect Finish Sonax - 400g', 109.9, 1, '000427'],
            ['OXICLEAN – REMOVEDOR DE CHUVA ÁCIDA', 45.9, 1, '001513'],
            ['Pasta Abrasiva 3M Cleaner Clay + Brinde Limpeza Final 3M 500ml', 86.9, 1, '000279'],
            ['Shampoo automotivo Espumacar Cadillac 5L', 28, 1, '000266'],
            ['Suporte c/ Velcro Ventilado 5\' p/ Roto 21 - Cadillac ou Kers', 56.9, 1, '001547'],
            ['Toalha de Microfibra Cadillac 40x40 cm', 9.9, 1, '001554'],
            ['Boina de Espuma Agressiva Azul Spider Scholl 6.5\'', 113.5, 1, 'BSA165'],
            ['Ironlac Descontaminante de Superfícies Cadillac 5L', 113.9, 1, '001824'],
            ['Lustrador Alto Brilho 2x1 Lincoln', 39.9, 1, '000086'],
            ['Meguiars Espuma Aplicadora', 11.23, 1, '000558'],
            ['Melamina Kers - Esponja Mágica', 11.9, 1, '001406'],
            ['Escova Pneus Cadillac', 40.9, 1, '000573'],
            ['Mini Politriz Roto Orbital Yes GFX-5802 220V + Kit Pincel Kers', 1100, 1, '002165']
        );

        $this->transaction->getOrder()
            ->setOrderId(date('mdHis'))
            ->setCallbackUrl(getenv('CALLBACK_URL'))
            ->setAmount(10.00)
            ->setInstallments(1)
            ->setVisitorId('9as7d8s9a7da9sd7sa9889a')
            ->setPayment($this->ipag->payment()
                    ->setMethod(Method::VISA)
                    ->setCreditCard($this->initCard())
            )->setCustomer($this->initCustomer())
            ->setCart($cart);
    }

    public function initCustomer()
    {
        return $this->ipag->customer()
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

    public function initCard()
    {
        return $this->ipag->creditCard()
            ->setNumber('4066553613548107')
            ->setHolder('FULANO')
            ->setExpiryMonth('10')
            ->setExpiryYear('2025')
            ->setCvc('123')
            ->setSave(true);
    }

    public function doPayment($capture = false)
    {
        if ($capture) {
            $this->transaction->getOrder()->setCapture('c');
        }

        return $this->transaction->execute();
    }

    public function testExecutePaymentSuccessfully()
    {
        $transaction = $this->doPayment();

        $this->assertEquals(getenv('APPROVED'), $transaction->payment->status);
        $this->assertEquals(36, strlen($transaction->creditCard->token));
    }

    public function testExecutePaymentWithCaptureSuccessfully()
    {
        $transaction = $this->doPayment(true);

        $this->assertEquals(getenv('APPROVED_CAPTURED'), $transaction->payment->status);
        $this->assertEquals(36, strlen($transaction->creditCard->token));
    }

    public function testExecuteSubscribePaymentSuccessfully()
    {
        $subscription = new Subscription();

        $subscription->setProfileId(time())
            ->setFrequency(1)
            ->setInterval('month')
            ->setStart(date('d/m/Y'));

        $this->transaction->getOrder()->setSubscription($subscription);

        $response = $this->doPayment();

        $this->assertEquals(getenv('APPROVED'), $response->payment->status);
        $this->assertNotEmpty($response->creditCard->token);
    }

    public function testSplitRuleWithPaymentInPercentage()
    {
        $payment = $this->transaction->getOrder()->getPayment();

        $payment->addSplitRule(
            $this->ipag->splitRule()
                ->setSellerId('c66fabf44786459e81e3c65e339a4fc9')
                ->setPercentage(10)
                ->setChargeProcessingFee(0)
                ->setLiable(1)
        );
        $payment->addSplitRule(
            $this->ipag->splitRule()
                ->setSellerId('c66fabf44786459e81e3c65e339a4fc9')
                ->setPercentage(15)
                ->setChargeProcessingFee(0)
                ->setLiable(1)
        );

        $response = $this->doPayment();

        $this->assertEquals(getenv('APPROVED'), $response->payment->status);
        $this->assertNotEmpty($response->splitRules);
        $this->assertEquals(2, count($response->splitRules));
    }

    public function testSplitRuleWithPaymentInAmount()
    {
        $payment = $this->transaction->getOrder()->getPayment();
        $payment->addSplitRule(
            $this->ipag->splitRule()
                ->setSellerId('c66fabf44786459e81e3c65e339a4fc9')
                ->setAmount(1.00)
                ->setChargeProcessingFee(0)
                ->setLiable(1)
        );
        $payment->addSplitRule(
            $this->ipag->splitRule()
                ->setSellerId('c66fabf44786459e81e3c65e339a4fc9')
                ->setPercentage(15)
                ->setChargeProcessingFee(1)
                ->setLiable(1)
        );

        $response = $this->doPayment();

        $this->assertEquals(getenv('APPROVED'), $response->payment->status);
        $this->assertNotEmpty($response->splitRules);
        $this->assertEquals(2, count($response->splitRules));
    }

    public function testReturnResponseErrorUnauthorized()
    {
        $this->ipag = new Ipag(new Authentication('no_login_error', '123'), Endpoint::SANDBOX);

        $transaction = $this->ipag->transaction();
        $transaction->getOrder()
            ->setOrderId(date('mdHis'))
            ->setCallbackUrl(getenv('CALLBACK_URL'))
            ->setAmount(10.00)
            ->setInstallments(1)
            ->setPayment($this->ipag->payment()
                    ->setMethod(Method::VISA)
            );

        $response = $transaction->execute();

        $this->assertEquals('401', $response->error);
        $this->assertEquals('Unauthorized', $response->errorMessage);
    }
}
