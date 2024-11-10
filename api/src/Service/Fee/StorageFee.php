<?php

namespace App\Service\Fee;

use App\Entity\Vehicle;

class StorageFee extends AbstractFeeStrategy
{
    public function applyFee(Vehicle $vehicle): void
    {
        $vehicle->setStorageFee($this->roundFee($this->feeConfig['fee']));
    }
}
