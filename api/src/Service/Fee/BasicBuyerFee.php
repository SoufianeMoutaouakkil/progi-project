<?php

namespace App\Service\Fee;

use App\Entity\Vehicle;

class BasicBuyerFee extends AbstractFeeStrategy
{
    public function applyFee(Vehicle $vehicle): void
    {

        $basicBuyerFee = $this->roundFee($vehicle->getBasePrice() * $this->feeConfig['fee']);

        $minFee = $this->feeConfig['min'][$vehicle->getVehicleType()] ?? 0;
        $maxFee = $this->feeConfig['max'][$vehicle->getVehicleType()] ?? PHP_INT_MAX;

        $basicBuyerFee = $basicBuyerFee < $minFee ? $minFee : $basicBuyerFee;
        $basicBuyerFee = $basicBuyerFee > $maxFee ? $maxFee : $basicBuyerFee;

        $vehicle->setBasicBuyerFee($basicBuyerFee);
    }
}
