<?php

namespace App\Payment;

class PaymentContext
{
    private $paymentStrategy;

    public function __construct(PaymentStrategyInterface $paymentStrategy)
    {
        $this->paymentStrategy = $paymentStrategy;
    }

    public function setPaymentStrategy(PaymentStrategyInterface $paymentStrategy)
    {
        $this->paymentStrategy = $paymentStrategy;
    }

    public function executePayment($amount)
    {
        return $this->paymentStrategy->processPayment($amount);
    }
}
