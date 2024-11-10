<?php

namespace App\Service\Fee;

use App\Entity\Vehicle;

class SellerSpecialFee extends AbstractFeeStrategy
{
    public function applyFee(Vehicle $vehicle): void
    {
        $sellerSpecialFee = $this->roundFee($vehicle->getBasePrice() * $this->feeConfig['fee'][$vehicle->getVehicleType()]);

        $vehicle->setSellerSpecialFee($sellerSpecialFee);
    }
}
