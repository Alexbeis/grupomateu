<?php

namespace Mateu\Backend\Animal\Domain;

use DateInterval;
use DateTime;

class BirthdayDaysCalculator
{
    /**
     * Return Age in Days
     *
     * @param $date
     *
     * @return Integer
     * @throws \Exception
     */
    public function getDaysAge($date) {
        $date2 = new DateTime();

        return $date->diff($date2)->format("%r%a");
    }
}