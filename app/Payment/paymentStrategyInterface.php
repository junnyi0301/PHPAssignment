<?php

namespace App\Payment;

interface PaymentStrategyInterface
{
    public function processPayment($amount);
}
