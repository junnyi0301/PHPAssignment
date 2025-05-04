<?php

namespace App\Patterns;

use Carbon\Carbon;

class PeakHourState implements DeliveryTimeState
{
    public function calculateTime(Carbon $time): Carbon
    {
        return $time->addMinutes(75);
    }
}