<?php

namespace App\Service\Fee;

use App\Entity\Vehicle;
use App\Exception\Config\FeeConfigException;

class StorageFee extends AbstractFeeStrategy
{
    public function applyFee(Vehicle $vehicle): void
    {
        if (!$this->isFeeEnabled()) {
            return;
        }

        $vehicle->setStorageFee($this->roundFee($this->feeConfig['fee']));
    }

    protected function validateFeeConfig(array $feeConfig): void
    {
        if (!isset($feeConfig['fee']) || !is_numeric($feeConfig['fee'])) {
            throw new FeeConfigException('Invalid fee config format for ' . $this->feeName);
        }
    }
}
