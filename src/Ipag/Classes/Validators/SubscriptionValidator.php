<?php

namespace Ipag\Classes\Validators;

use Ipag\Classes\Enum\Interval;

final class SubscriptionValidator
{
    public function isValidFrequency($frequency)
    {
        return (bool) (is_numeric($frequency) && strlen($frequency) >= 1 && strlen($frequency) <= 2);
    }

    public function isValidInterval($interval)
    {
        switch ($interval) {
            case Interval::DAY:
            case Interval::WEEK:
            case Interval::MONTH:
                return true;
            default:
                return false;
        }
    }

    public function isValidCycle($cycle)
    {
        return (bool) (is_numeric($cycle) && strlen($cycle) >= 1 && strlen($cycle) <= 3);
    }

    public function isValidProfileId($profileId)
    {
        return (bool) (is_numeric($profileId) && strlen($profileId) <= 32);
    }
}
