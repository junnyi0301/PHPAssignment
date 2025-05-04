<?php

namespace App\Patterns;

use Carbon\Carbon;

interface DeliveryTimeState
{
    public function calculateTime(Carbon $time): Carbon;
}