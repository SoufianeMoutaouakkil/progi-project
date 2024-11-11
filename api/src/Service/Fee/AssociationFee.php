<?php

namespace App\Service\Fee;

use App\Entity\Vehicle;
use App\Exception\Config\FeeConfigException;

class AssociationFee extends AbstractFeeStrategy
{
    public function applyFee(Vehicle $vehicle): void
    {
        if (!$this->isFeeEnabled()) {
            return;
        }

        $associationFeeSteps = $this->feeConfig['steps'];

        $associationFee = 0;

        foreach ($associationFeeSteps as $step) {
            if (
                $vehicle->getBasePrice() >= $step['min'] &&
                $vehicle->getBasePrice() <= ($step['max'] ?? PHP_INT_MAX)
            ) {
                $associationFee = $this->roundFee($step['fee']);
                break;
            }
        }

        $vehicle->setAssociationFee($associationFee);
    }

    protected function validateFeeConfig(array $feeConfig): void
    {
        if (!isset($feeConfig['steps']) || !is_array($feeConfig['steps'])) {
            throw new FeeConfigException('Invalid fee config for ' . $this->feeName);
        }

        foreach ($feeConfig['steps'] as $step) {
            if (
                !isset($step['min']) || !is_numeric($step['min']) ||
                !isset($step['fee']) || !is_numeric($step['fee'])
            ) {
                throw new FeeConfigException('Invalid fee step config for ' . $this->feeName);
            }
        }
    }
}
