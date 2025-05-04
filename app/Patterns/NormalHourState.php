<?php

namespace App\Patterns;

use Carbon\Carbon;

class NormalHourState implements DeliveryTimeState
{
    public function calculateTime(Carbon $time): Carbon
    {
        return $time->addHour();
    }
}