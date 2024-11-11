<?php

namespace App\Entity;

use App\Exception\BusinessLogicException;
use JsonSerializable;

class Vehicle implements JsonSerializable
{
    public const TYPE_COMMON = 'common';
    public const TYPE_LUXURY = 'luxury';

    private float $basePrice;
    private string $vehicleType;

    private float $basicBuyerFee = 0.0;
    private float $sellerSpecialFee = 0.0;
    private float $associationFee = 0.0;
    private float $storageFee = 0.0;

    public function __construct(float $basePrice, string $vehicleType)
    {
        $this->setBasePrice($basePrice);
        $this->setVehicleType($vehicleType);
    }

    public static function isValidVehicleType(string $vehicleType): bool
    {
        return in_array($vehicleType, [self::TYPE_COMMON, self::TYPE_LUXURY], true);
    }

    private function setBasePrice(float $basePrice): void
    {
        if ($basePrice < 0) {
            throw new BusinessLogicException('Base price must be a positive number');
        }

        $this->basePrice = round($basePrice, 2);
    }

    public function getBasePrice(): float
    {
        return $this->basePrice;
    }

    private function setVehicleType(string $vehicleType): void
    {
        if (!self::isValidVehicleType($vehicleType)) {
            throw new BusinessLogicException('Invalid vehicle type');
        }

        $this->vehicleType = $vehicleType;
    }

    public function getVehicleType(): string
    {
        return $this->vehicleType;
    }

    public function getBasicBuyerFee(): float
    {
        return $this->basicBuyerFee;
    }

    public function setBasicBuyerFee(float $fee): void
    {
        $this->basicBuyerFee = $fee;
    }

    public function getSellerSpecialFee(): float
    {
        return $this->sellerSpecialFee;
    }

    public function setSellerSpecialFee(float $fee): void
    {
        $this->sellerSpecialFee = $fee;
    }

    public function getAssociationFee(): float
    {
        return $this->associationFee;
    }

    public function setAssociationFee(float $fee): void
    {
        $this->associationFee = $fee;
    }

    public function getStorageFee(): float
    {
        return $this->storageFee;
    }

    public function setStorageFee(float $fee): void
    {
        $this->storageFee = $fee;
    }

    public function getTotalFees(): float
    {
        return $this->basicBuyerFee + $this->sellerSpecialFee + $this->associationFee + $this->storageFee;
    }

    public function getTotalPrice(): float
    {
        return $this->basePrice + $this->getTotalFees();
    }

    public function jsonSerialize(): array
    {
        return [
            'basePrice' => $this->basePrice,
            'vehicleType' => $this->vehicleType,
            'fees' => [
                'basicBuyerFee' => $this->basicBuyerFee,
                'sellerSpecialFee' => $this->sellerSpecialFee,
                'associationFee' => $this->associationFee,
                'storageFee' => $this->storageFee
            ],
            'totalFees' => $this->getTotalFees(),
            'totalPrice' => $this->getTotalPrice()
        ];
    }
}
