<?php

namespace App\Service\Fee;

use App\Entity\Vehicle;
use App\Exception\Config\FeeConfigException;

class BasicBuyerFee extends AbstractFeeStrategy
{
    public function applyFee(Vehicle $vehicle): void
    {
        if (!$this->isFeeEnabled()) {
            return;
        }

        $basicBuyerFee = $this->roundFee($vehicle->getBasePrice() * $this->feeConfig['fee']);

        $minFee = $this->feeConfig['min'][$vehicle->getVehicleType()] ?? 0;
        $maxFee = $this->feeConfig['max'][$vehicle->getVehicleType()] ?? PHP_INT_MAX;

        $basicBuyerFee = $basicBuyerFee < $minFee ? $minFee : $basicBuyerFee;
        $basicBuyerFee = $basicBuyerFee > $maxFee ? $maxFee : $basicBuyerFee;

        $vehicle->setBasicBuyerFee($basicBuyerFee);
    }

    protected function validateFeeConfig(array $feeConfig): void
    {
        $this->validateConfigFormat($feeConfig);

        $this->validateMinFeeConfig($feeConfig['min']);

        $this->validateMaxFeeConfig($feeConfig['max']);
    }

    private function validateConfigFormat(array $feeConfig): void
    {
        if (
            !isset($feeConfig['fee']) || !is_numeric($feeConfig['fee']) ||
            !isset($feeConfig['min']) || !is_array($feeConfig['min']) ||
            !isset($feeConfig['max']) || !is_array($feeConfig['max'])
        ) {
            throw new FeeConfigException('Invalid fee config format for ' . $this->feeName);
        }
    }

    private function validateMinFeeConfig(array $minFeeConfig): void
    {
        foreach ($minFeeConfig as $vehicleType => $minFee) {
            if (!is_numeric($minFee) || $minFee < 0) {
                throw new FeeConfigException('Invalid minFee config for ' . $this->feeName);
            }

            if (!Vehicle::isValidVehicleType($vehicleType)) {
                throw new FeeConfigException('Invalid vehicle type in min config for ' . $this->feeName);
            }
        }
    }

    private function validateMaxFeeConfig(array $maxFeeConfig): void
    {
        foreach ($maxFeeConfig as $vehicleType => $maxFee) {
            if (!is_numeric($maxFee) || $maxFee < 0) {
                throw new FeeConfigException('Invalid maxFee config for ' . $this->feeName);
            }

            if (!Vehicle::isValidVehicleType($vehicleType)) {
                throw new FeeConfigException('Invalid vehicle type in max config for ' . $this->feeName);
            }
        }
    }
}
