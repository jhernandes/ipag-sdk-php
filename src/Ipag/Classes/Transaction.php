<?php

namespace Ipag\Classes;

use Ipag\Classes\Enum\Action;
use Ipag\Classes\Enum\Operation;
use Ipag\Classes\Serializer\PaymentSerializer;
use Ipag\Classes\Serializer\Serializer;
use Ipag\Ipag;
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

    public function __construct(Ipag $ipag)
    {
        parent::__construct($ipag);
        $this->apiService = new Services\ApiActionService();
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
        return $this->apiService
            ->execute(new PaymentSerializer($this, Action::PAYMENT, Operation::PAYMENT));
    }

    public function consult()
    {
        return $this->apiService
            ->execute(new Serializer($this, Action::CONSULT, Operation::CONSULT));
    }

    public function cancel()
    {
        return $this->apiService
            ->execute(new Serializer($this, Action::CANCEL, Operation::CANCEL));
    }

    public function capture()
    {
        return $this->apiService
            ->execute(new Serializer($this, Action::CAPTURE, Operation::CAPTURE));
    }

    public function authenticate()
    {
        $authentication = $this->getIpag()->getAuthentication();

        $this->getOnlyPostClient()
            ->setUser($authentication->getIdentification())
            ->setPassword($authentication->getApiKey());

        return $this;
    }
}
