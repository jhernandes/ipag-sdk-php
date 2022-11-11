<?php

namespace Ipag\Classes;

use Ipag\Classes\Contracts\Emptiable;
use Ipag\Classes\Contracts\ObjectSerializable;
use Ipag\Classes\Traits\EmptiableTrait;

final class Subscription extends BaseResource implements Emptiable, ObjectSerializable
{
    use EmptiableTrait;

    /**
     * @var string
     */
    private $profileId;

    /**
     * @var int
     */
    private $frequency;

    /**
     * @var string
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
     * @var float
     */
    private $amount;

    /**
     * @var bool
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
     * @var float
     */
    private $trialAmount;

    /**
     * @var Validators\SubscriptionValidator
     */
    private $validator;

    private function validator()
    {
        if (is_null($this->validator)) {
            $this->validator = new Validators\SubscriptionValidator();
        }

        return $this->validator;
    }

    /**
     * @return int
     */
    public function getFrequency()
    {
        return $this->frequency;
    }

    /**
     * @return string
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
     * @return float
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @return bool
     */
    public function isTrial()
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
     * @return float
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
        if (!$this->validator()->isValidFrequency($frequency)) {
            throw new \UnexpectedValueException(
                'A frequencia não é válida ou não tem entre 1 e 2 caracteres'
            );
        }
        $this->frequency = $frequency;

        return $this;
    }

    /**
     * @param string $interval
     */
    public function setInterval($interval)
    {
        if (!$this->validator()->isValidInterval($interval)) {
            throw new \UnexpectedValueException(
                'O intervalo (interval) não é válido'
            );
        }

        $this->interval = $interval;

        return $this;
    }

    /**
     * @param string $start
     */
    public function setStart($start)
    {
        if (!$this->getDateUtil()->isValid($start)) {
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
        if (!$this->validator()->isValidCycle($cycle)) {
            throw new \UnexpectedValueException(
                'O ciclo deve ser númerico e ter entre 1 e 3 caracteres.'
            );
        }
        $this->cycle = $cycle;

        return $this;
    }

    /**
     * @param float $amount
     */
    public function setAmount($amount)
    {
        $this->amount = $this->getNumberUtil()->convertToDouble($amount);

        return $this;
    }

    /**
     * @param bool $trial
     */
    public function setTrial($trial)
    {
        $this->trial = (bool) $trial;

        return $this;
    }

    /**
     * @param int $trialCycle
     */
    public function setTrialCycle($trialCycle)
    {
        if (!$this->validator()->isValidCycle($trialCycle)) {
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
        if (!$this->validator()->isValidFrequency($trialFrequency)) {
            throw new \UnexpectedValueException(
                'A frequencia trial não é válida ou não tem entre 1 e 2 caracteres'
            );
        }
        $this->trialFrequency = $trialFrequency;

        return $this;
    }

    /**
     * @param float $trialAmount
     */
    public function setTrialAmount($trialAmount)
    {
        $this->trialAmount = $this->getNumberUtil()->convertToDouble($trialAmount);

        return $this;
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
        if (!$this->validator()->isValidProfileId($profileId)) {
            throw new \UnexpectedValueException(
                'Profile ID deve ser somente númerico e ter no máximo 32 caracteres.'
            );
        }
        $this->profileId = $profileId;

        return $this;
    }

    public function serialize()
    {
        if ($this->isEmpty()) {
            return [];
        }

        return [
            'profile_id'       => urlencode((string) $this->getProfileId()),
            'frequencia'       => urlencode((string) $this->getFrequency()),
            'intervalo'        => urlencode((string) $this->getInterval()),
            'inicio'           => urlencode((string) $this->getStart()),
            'ciclos'           => urlencode((string) $this->getCycle()),
            'valor_rec'        => urlencode((string) $this->getAmount()),
            'trial'            => urlencode((string) $this->isTrial()),
            'trial_ciclos'     => urlencode((string) $this->getTrialCycle()),
            'trial_frequencia' => urlencode((string) $this->getTrialFrequency()),
            'trial_valor'      => urlencode((string) $this->getTrialAmount()),
        ];
    }
}
