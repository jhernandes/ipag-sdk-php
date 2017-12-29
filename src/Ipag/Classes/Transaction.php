<?php

namespace Ipag\Classes;

final class Transaction extends IpagResource
{
    /**
     * @var Order
     */
    private $order;

    /**
     * @var string
     */
    private $tid;

    /**
     * @var string
     */
    private $acquirer;

    /**
     * @var string
     */
    private $acquirerMessage;

    /**
     * @var string
     */
    private $paymentStatus;

    /**
     * @var string
     */
    private $message;

    /**
     * @var string
     */
    private $urlAutentication;

    /**
     * @return Order
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * @param Order $order
     */
    public function setOrder(Order $order)
    {
        $this->order = $order;

        return $this;
    }

    /**
     * @return string
     */
    public function getTid()
    {
        return $this->tid;
    }

    /**
     * @param string $tid
     */
    public function setTid($tid)
    {
        $this->tid = $tid;

        return $this;
    }

    /**
     * @return string
     */
    public function getAcquirer()
    {
        return $this->acquirer;
    }

    /**
     * @param string $acquirer
     */
    public function setAcquirer($acquirer)
    {
        $this->acquirer = $acquirer;

        return $this;
    }

    /**
     * @return string
     */
    public function getAcquirerMessage()
    {
        return $this->acquirerMessage;
    }

    /**
     * @param string $acquirerMessage
     */
    public function setAcquirerMessage($acquirerMessage)
    {
        $this->acquirerMessage = $acquirerMessage;

        return $this;
    }

    /**
     * @return string
     */
    public function getPaymentStatus()
    {
        return $this->paymentStatus;
    }

    /**
     * @param string $paymentStatus
     */
    public function setPaymentStatus($paymentStatus)
    {
        $this->paymentStatus = $paymentStatus;

        return $this;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param string $message
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * @return string
     */
    public function getUrlAutentication()
    {
        return $this->urlAutentication;
    }

    /**
     * @param string $urlAutentication
     */
    public function setUrlAutentication($urlAutentication)
    {
        $this->urlAutentication = $urlAutentication;

        return $this;
    }

    /**
     * @return OnlyPostHttpClientInterface
     */
    public function getOnlyPostClient()
    {
        return $this->onlyPostClient;
    }

    /**
     * @param OnlyPostHttpClientInterface $onlyPostClient
     */
    public function setOnlyPostClient(OnlyPostHttpClientInterface $onlyPostClient)
    {
        $this->onlyPostClient = $onlyPostClient;

        return $this;
    }

    protected function populate(\stdClass $response)
    {
        return $response;
    }

    public function execute()
    {
        $this->getOrder()->setOperation(Enum\Operation::PAYMENT);

        $serializer = new Serializer\PaymentSerializer($this);

        $response = $this->sendHttpRequest($this->getIpag()->getEndpoint()->payment(), $serializer->serialize());

        return $this->populate($response);
    }

    public function consult()
    {
        //TODO: Enviar para /consultar no iPag
    }

    public function cancel()
    {
        //TODO: Enviar para /cancelar no iPag
    }

    public function capture()
    {
        //TODO: Enviar para /capturar no iPag
    }
}
