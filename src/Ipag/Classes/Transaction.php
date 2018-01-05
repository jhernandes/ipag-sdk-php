<?php

namespace Ipag\Classes;

use stdClass;

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
     * @return Order
     */
    public function getOrder()
    {
        if (is_null($this->order)) {
            $this->order = new Order();
        }

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

    public function populate(stdClass $response)
    {
        return (new Services\TransactionResponseService())->populate($response);
    }

    public function execute()
    {
        return (new Services\PaymentService($this))->execute();
    }

    public function consult()
    {
        return (new Services\ConsultService($this))->execute();
    }

    public function cancel()
    {
        return (new Services\CancelService($this))->execute();
    }

    public function capture()
    {
        return (new Services\CaptureService($this))->execute();
    }

    private function authenticate()
    {
        $authentication = $this->getIpag()->getAuthentication();
        $this->getOnlyPostClient()
            ->setUser($authentication->getIdentification())
            ->setPassword($authentication->getApiKey());

        return $this;
    }

    final public function sendHttpRequest($endpoint, $parameters)
    {
        $this->authenticate();

        return parent::sendHttpRequest($endpoint, $parameters);
    }
}
