<?php

namespace App\Service\Fee;

use App\Entity\Vehicle;

abstract class AbstractFeeStrategy
{
    protected $feeConfig;

    public function __construct($feeConfig)
    {
        $this->feeConfig = $feeConfig;
    }

    abstract public function applyFee(Vehicle $vehicle): void;

    protected function roundFee(float $fee): float
    {
        return round($fee, 2);
    }
}
