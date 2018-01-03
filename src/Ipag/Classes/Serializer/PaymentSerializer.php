<?php

namespace Ipag\Classes\Serializer;

use Ipag\Classes\Transaction;

final class PaymentSerializer implements Serializer
{
    /**
     * @var Transaction
     */
    private $transaction;

    public function __construct(Transaction $transaction)
    {
        $this->transaction = $transaction;
    }

    public function serialize()
    {
        $serializedReturnType = array(
            'retorno_tipo' => urlencode('xml'),
            'boleto_tipo' => urlencode('xml'),
        );

        $serializedUser = $this->serializeUser($this->transaction->getIpag()->getAuthentication());
        $serializedOrder = $this->serializeOrder($this->transaction->getOrder());

        return array_merge($serializedReturnType, $serializedUser, $serializedOrder);
    }

    private function serializeUser($user)
    {
        $serializedUser = array(
            'identificacao' => urlencode($user->getIdentification()),
        );

        $parceiro = $user->getIdentification2();
        if (!empty($parceiro)) {
            $serializedUser['identificacao2'] = urlencode($parceiro);
        }

        return $serializedUser;
    }

    private function serializeOrder($order)
    {
        if (empty($order)) {
            throw new \Exception('É necessário informar os dados do Pedido (Order)');
        }

        $serializedOrder = array(
            'pedido' => urlencode($order->getOrderId()),
            'operacao' => urlencode($order->getOperation()),
            'url_retorno' => urlencode($order->getCallbackUrl()),
            'valor' => urlencode($order->getAmount()),
            'parcelas' => urlencode($order->getInstallments()),
            'vencto' => urlencode($order->getExpiry()),
            'stelo_fingerprint' => urlencode($order->getFingerprint()),
        );

        $serializedPayment = $this->serializePayment($order->getPayment());
        $serializedCart = $this->serializeCart($order->getCart());
        $serializedCustomer = $this->serializeCustomer($order->getCustomer());
        $serializedSubscription = $this->serializeSubscription($order->getSubscription());

        return array_merge(
            $serializedOrder,
            $serializedPayment,
            $serializedCart,
            $serializedCustomer,
            $serializedSubscription
        );
    }

    private function serializePayment($payment)
    {
        if (empty($payment)) {
            throw new \Exception('É necessário informar os dados do Pagamento (Payment)');
        }

        $serializedMethod = array(
            'metodo' => urlencode($payment->getMethod()),
        );

        $serializedInstructions = $this->serializeInstructions($payment->getInstructions());

        $serializedSoftDescriptor = $this->serializeSoftDescriptor($payment->getSoftDescriptor());

        $serializedCreditCard = $this->serializeCreditCard($payment->getCreditCard());

        return array_merge(
            $serializedMethod,
            $serializedInstructions,
            $serializedSoftDescriptor,
            $serializedCreditCard
        );
    }

    private function serializeInstructions($instructions)
    {
        $serializedInstructions = array();
        foreach ($instructions as $key => $instruction) {
            $serializedInstructions["instrucoes[{$key}]"] = urlencode($instruction);
        }

        return $serializedInstructions;
    }

    private function serializeSoftDescriptor($softDescriptor)
    {
        $serializedSoftDescriptor = array();
        if (!empty($softDescriptor)) {
            $serializedSoftDescriptor['softdescriptor'] = urlencode($softDescriptor);
        }

        return $serializedSoftDescriptor;
    }

    private function serializeCreditCard($creditCard)
    {
        if (empty($creditCard)) {
            return array();
        }

        if ($creditCard->hasToken()) {
            return $this->serializeCreditCardWithToken($creditCard);
        }

        return $this->serializeCreditCardWithNumber($creditCard);
    }

    private function serializeCreditCardWithNumber($creditCard)
    {
        $serializedCreditCard = array(
            'num_cartao' => urlencode($creditCard->getNumber()),
            'nome_cartao' => urlencode($creditCard->getHolder()),
            'mes_cartao' => urlencode($creditCard->getExpiryMonth()),
            'ano_cartao' => urlencode($creditCard->getExpiryYear()),
        );

        if ($creditCard->hasCvc()) {
            $serializedCreditCard['cvv_cartao'] = urlencode($creditCard->getCvc());
        }

        if ($creditCard->getSave()) {
            $serializedCreditCard['gera_token_cartao'] = urlencode($creditCard->getSave());
        }

        return $serializedCreditCard;
    }

    private function serializeCreditCardWithToken($creditCard)
    {
        return array(
            'token_cartao' => urlencode($creditCard->getToken()),
        );
    }

    private function serializeCart($cart)
    {

        if (empty($cart)) {
            return array();
        }

        $serializedProducts = $this->serializeProducts($cart->getProducts());

        return array(
            'descricao_pedido' => urlencode(json_encode($serializedProducts)),
        );

    }

    private function serializeProducts($products)
    {
        $serializedProducts = [];
        $i = 1;

        foreach ($products as $product) {
            $serializedProducts[$i++] = array(
                'descr' => $product->getName(),
                'valor' => $product->getUnitPrice(),
                'quant' => $product->getQuantity(),
                'id' => $product->getSku(),
            );
        }
        return $serializedProducts;
    }

    private function serializeCustomer($customer)
    {
        if (empty($customer)) {
            return array();
        }

        $serializedCustomer = array(
            'nome' => urlencode($customer->getName()),
            'email' => urlencode($customer->getEmail()),
            'doc' => urlencode($customer->getTaxpayerId()),
            'fone' => urlencode($customer->getPhone()),
        );

        $serializedCustomerAddress = $this->serializeCustomerAddress($customer->getAddress());

        return array_merge($serializedCustomer, $serializedCustomerAddress);
    }

    private function serializeCustomerAddress($address)
    {
        if (empty($address)) {
            return array();
        }

        $serializedCustomerAddress = array(
            'endereco' => urlencode($address->getStreet()),
            'numero_endereco' => urlencode($address->getNumber()),
            'complemento' => urlencode($address->getComplement()),
            'bairro' => urlencode($address->getNeighborhood()),
            'cidade' => urlencode($address->getCity()),
            'estado' => urlencode($address->getState()),
            'pais' => urlencode($address->getCountry()),
            'cep' => urlencode($address->getZipCode()),
        );

        return $serializedCustomerAddress;
    }

    private function serializeSubscription($subscription)
    {
        if (empty($subscription)) {
            return array();
        }

        return array(
            'profile_id' => urlencode($subscription->getProfileId()),
            'frequencia' => urlencode($subscription->getFrequency()),
            'intervalo' => urlencode($subscription->getInterval()),
            'inicio' => urlencode($subscription->getStart()),
            'ciclos' => urlencode($subscription->getCycle()),
            'valor_rec' => urlencode($subscription->getAmount()),
            'trial' => urlencode($subscription->getTrial()),
            'trial_ciclos' => urlencode($subscription->getTrialCycle()),
            'trial_frequencia' => urlencode($subscription->getTrialFrequency()),
            'trial_valor' => urlencode($subscription->getTrialAmount()),
        );
    }
}
