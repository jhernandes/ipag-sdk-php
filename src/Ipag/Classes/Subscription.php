<?php

namespace Ipag\Classes;

final class Subscription
{
    /**
     * @var string
     */
    private $profileId;

    /**
     * @var int
     */
    private $frequency;

    /**
     * @var int
     */
    private $interval;

    /**
     * @var string
     */
    private $start;

    /**
     * @var int
     */
    private $cycle;

    /**
     * @var double
     */
    private $amount;

    /**
     * @var boolean
     */
    private $trial;

    /**
     * @var int
     */
    private $trialCycle;

    /**
     * @var int
     */
    private $trialFrequency;

    /**
     * @var double
     */
    private $trialAmount;

    /**
     * @return int
     */
    public function getFrequency()
    {
        return $this->frequency;
    }

    /**
     * @return int
     */
    public function getInterval()
    {
        return $this->interval;
    }

    /**
     * @return string
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * @return int
     */
    public function getCycle()
    {
        return $this->cycle;
    }

    /**
     * @return double
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @return boolean
     */
    public function getTrial()
    {
        return $this->trial;
    }

    /**
     * @return int
     */
    public function getTrialCycle()
    {
        return $this->trialCycle;
    }

    /**
     * @return int
     */
    public function getTrialFrequency()
    {
        return $this->trialFrequency;
    }

    /**
     * @return double
     */
    public function getTrialAmount()
    {
        return $this->trialAmount;
    }

    /**
     * @param int $frequency the frequency
     */
    public function setFrequency($frequency)
    {
        if (!$this->isValidFrequency($frequency)) {
            throw new \UnexpectedValueException(
                'A frequencia não é válida ou não tem entre 1 e 2 caracteres'
            );
        }
        $this->frequency = $frequency;

        return $this;
    }

    /**
     * Sets the value of interval.
     */
    public function setInterval($interval)
    {
        if (!$this->isValidInterval($interval)) {
            throw new \UnexpectedValueException(
                'O intervalo (interval) não é válido'
            );
        }

        $this->interval = $interval;

        return $this;
    }

    /**
     * @param string $start the start
     */
    public function setStart($start)
    {
        if (!$this->isValidStartFormatDate($start)) {
            throw new \UnexpectedValueException(
                'A data de início não é valida ou está em formato incorreto, deve ser informada utilizando o formato dd/mm/aaaa'
            );
        }

        $this->start = $start;

        return $this;
    }

    /**
     * @param int $cycle
     */
    public function setCycle($cycle)
    {
        if (!$this->isValidCycle($cycle)) {
            throw new \UnexpectedValueException(
                'O ciclo deve ser númerico e ter entre 1 e 3 caracteres.'
            );
        }
        $this->cycle = $cycle;

        return $this;
    }

    /**
     * @param double $amount
     */
    public function setAmount($amount)
    {
        if (!$this->isValidAmount($amount)) {
            throw new \UnexpectedValueException(
                'O Valor do Pedido deve ser do tipo double (ex: 1.00)'
            );
        }
        $this->amount = $amount;

        return $this;
    }

    /**
     * @param boolean $trial
     */
    public function setTrial($trial)
    {
        $this->trial = (boolean) $trial;

        return $this;
    }

    /**
     * @param int $trialCycle
     */
    public function setTrialCycle($trialCycle)
    {
        if (!$this->isValidCycle($trialCycle)) {
            throw new \UnexpectedValueException(
                'O ciclo trial deve ser númerico e ter entre 1 e 3 caracteres.'
            );
        }
        $this->trialCycle = $trialCycle;

        return $this;
    }

    /**
     * @param int $trialFrequency
     */
    public function setTrialFrequency($trialFrequency)
    {
        if (!$this->isValidFrequency($trialFrequency)) {
            throw new \UnexpectedValueException(
                'A frequencia trial não é válida ou não tem entre 1 e 2 caracteres'
            );
        }
        $this->trialFrequency = $trialFrequency;

        return $this;
    }

    /**
     * @param double $trialAmount
     */
    public function setTrialAmount($trialAmount)
    {
        if (!$this->isValidAmount($trialAmount)) {
            throw new \UnexpectedValueException(
                'O Valor do Pedido deve ser do tipo double (ex: 1.00)'
            );
        }
        $this->trialAmount = $trialAmount;

        return $this;
    }

    private function isValidFrequency($frequency)
    {
        return (boolean) (!is_numeric($frequency) || strlen($frequency) < 1 || strlen($frequency) > 2);
    }

    private function isValidInterval($interval)
    {
        switch ($interval) {
            case Enum\Interval::DAY:
            case Enum\Interval::WEEK:
            case Enum\Interval::MONTH:
                return true;
            default:
                return false;
        }
        return false;
    }

    private function isValidStartFormatDate($date)
    {
        /* dd/mm/yyyy */
        if (preg_match("/([0-9]{2})\/([0-9]{2})\/([0-9]{4})/", $date, $matches)) {
            if (checkdate($matches[2], $matches[1], $matches[3])) {
                return true;
            }
        }
        return false;
    }

    private function isValidCycle($cycle)
    {
        return (boolean) (!is_numeric($cycle) || strlen($cycle) < 1 || strlen($cycle) > 3);
    }

    private function isValidAmount($amount)
    {
        return (boolean) is_double($amount);
    }

    /**
     * @return string
     */
    public function getProfileId()
    {
        return $this->profileId;
    }

    /**
     * @param string $profileId
     */
    public function setProfileId($profileId)
    {
        if (!$this->isValidProfileId($profileId)) {
            throw new \UnexpectedValueException(
                'Profile ID deve ser somente númerico e ter no máximo 32 caracteres.'
            );

        }
        $this->profileId = $profileId;

        return $this;
    }

    private function isValidProfileId($profileId)
    {
        return (boolean) (!is_numeric($profileId) || strlen($profileId) > 32);
    }
}
