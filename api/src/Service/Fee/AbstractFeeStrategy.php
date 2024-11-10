<?php

namespace App\Service\Fee;

use App\Entity\Vehicle;
use App\Exception\Config\FeeConfigException;

abstract class AbstractFeeStrategy
{

    protected const FEES = [
        StorageFee::class => 'storage_fee',
        BasicBuyerFee::class => 'basic_buyer_fee',
        SellerSpecialFee::class => 'seller_special_fee',
        AssociationFee::class => 'association_fee'
    ];

    protected $feeConfig;
    protected $feeName;

    protected $feeEnabled = true;

    public function __construct($feeConfig)
    {
        $this->feeName = static::FEES[static::class] ?? null;
        if (!$this->feeName) {
            throw new FeeConfigException('Trying to apply invalid fee: ' . static::class);
        }

        if (!is_array($feeConfig)) {
            throw new FeeConfigException('Invalid fee config for ' . $this->feeName);
        }

        $this->validateFeeConfig($feeConfig);
        $this->feeConfig = $feeConfig;
        $this->setFeeEnabled($feeConfig['enabled'] ?? true);
    }

    abstract public function applyFee(Vehicle $vehicle): void;

    abstract protected function validateFeeConfig(array $feeConfig): void;

    protected function roundFee(float $fee): float
    {
        return round($fee, 2);
    }

    protected function setFeeEnabled(bool $feeEnabled): void
    {
        $this->feeEnabled = $feeEnabled === true;
    }

    protected function isFeeEnabled(): bool
    {
        return $this->feeEnabled;
    }
}
