<?php

namespace App\Service\Fee;

use App\Entity\Vehicle;
use App\Exception\Config\FeeConfigException;

class SellerSpecialFee extends AbstractFeeStrategy
{
    public function applyFee(Vehicle $vehicle): void
    {
        if (!$this->isFeeEnabled()) {
            return;
        }

        $sellerSpecialFee = $this->roundFee($vehicle->getBasePrice() * $this->feeConfig['fee'][$vehicle->getVehicleType()]);

        $vehicle->setSellerSpecialFee($sellerSpecialFee);
    }

    protected function validateFeeConfig(array $feeConfig): void
    {
        if (!isset($feeConfig['fee']) || !is_array($feeConfig['fee'])) {
            throw new FeeConfigException('Invalid fee config format for ' . $this->feeName);
        }

        foreach ($feeConfig['fee'] as $vehicleType => $fee) {
            if (!is_numeric($fee) || $fee < 0) {
                throw new FeeConfigException('Invalid fee config value for ' . $this->feeName);
            }

            if (!Vehicle::isValidVehicleType($vehicleType)) {
                throw new FeeConfigException('Invalid vehicle type in fee config for ' . $this->feeName);
            }
        }
    }
}
