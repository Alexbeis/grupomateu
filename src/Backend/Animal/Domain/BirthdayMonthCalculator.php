<?php

namespace Mateu\Backend\Animal\Domain;

use DateInterval;
use DateTime;

class BirthdayMonthCalculator
{
    /**
     * Return Age in Months
     *
     * @param $date
     *
     * @return Integer
     * @throws \Exception
     */
    public function getMonthAge($date) {
        $now = new DateTime();
        $diff = date_diff($date, $now);

        return sprintf('%d m y %d d',$diff->m + $diff->y * 12, $diff->d);
    }
}