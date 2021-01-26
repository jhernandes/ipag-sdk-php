<?php

namespace Ipag\Classes;

use Ipag\Classes\Contracts\Emptiable;
use Ipag\Classes\Traits\EmptiableTrait;

final class Pix extends BaseResource implements Emptiable
{
    use EmptiableTrait;

    /**
     * @var string
     */
    private $link;

    /**
     * @var string
     */
    private $qrCode;

    /**
     * @return string
     */
    public function getQrCode()
    {
        return $this->qrCode;
    }

    /**
     * @return string
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * @param string $qrCode
     */
    public function setQrCode($qrCode)
    {
        $this->qrCode = $qrCode;

        return $this;
    }

    /**
     * @param string $link
     */
    public function setLink($link)
    {
        $this->link = $link;

        return $this;
    }

    public function serialize()
    {
        if ($this->isEmpty()) {
            return [];
        }

        return [
            'link'   => urlencode($this->getLink()),
            'qrCode' => urlencode($this->getQrCode()),
        ];
    }
}
