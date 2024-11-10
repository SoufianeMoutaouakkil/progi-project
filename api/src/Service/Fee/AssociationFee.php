<?php

namespace App\Service\Fee;

use App\Entity\Vehicle;

class AssociationFee extends AbstractFeeStrategy
{
    public function applyFee(Vehicle $vehicle): void
    {
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
}
