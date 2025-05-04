<?php


namespace App\Patterns;

use Carbon\Carbon;

class DeliveryTimeContext
{
    protected $state;

    public function __construct(Carbon $time)
    {
        $hour = $time->hour;
        $this->state = ($hour >= 17 && $hour < 20) 
            ? new PeakHourState() 
            : new NormalHourState();
    }

    public function getDeliveryTime(Carbon $time): Carbon
    {
        return $this->state->calculateTime($time);
    }
}
