<?php

namespace Mateu\Backend\Animal\Domain;

use DateInterval;
use DateTime;

class BirthdayMonthCalculator extends DateTime
{
    /**
     * Return difference between $this and $now
     *
     * @param Datetime|String $now
     * @return DateInterval
     */
    public function difference($now = 'NOW') {
        if(!($now instanceOf DateTime)) {
            $now = new DateTime($now);
            $now->format('Y-m-d');
        }
        return parent::diff($now, true);
    }

    /**
     * Return Age in Months
     *
     * @param Datetime|String $now
     * @return Integer
     */
    public function getMonthAge($now = 'NOW') {
        $diff = $this->difference($now);

        return $diff->m + $diff->y * 12;
    }




}