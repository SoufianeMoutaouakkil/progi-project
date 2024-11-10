<?php

namespace App\Entity;

class Vehicle implements \JsonSerializable
{
    public const TYPE_COMMON = 'common';
    public const TYPE_LUXURY = 'luxury';

    private float $basePrice;
    private string $vehicleType;

    private float $basicBuyerFee;
    private float $sellerSpecialFee;
    private float $associationFee;
    private float $storageFee;

    public function __construct(float $basePrice, string $vehicleType)
    {
        $this->basePrice = $basePrice;
        $this->vehicleType = $vehicleType;

        $this->basicBuyerFee = 0.0;
        $this->sellerSpecialFee = 0.0;
        $this->associationFee = 0.0;
        $this->storageFee = 0.0;
    }

    public function getBasePrice(): float
    {
        return $this->basePrice;
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
            'base_price' => $this->basePrice,
            'vehicle_type' => $this->vehicleType,
            'fees' => [
                'basic_buyer_fee' => $this->basicBuyerFee,
                'seller_special_fee' => $this->sellerSpecialFee,
                'association_fee' => $this->associationFee,
                'storage_fee' => $this->storageFee
            ],
            'total_fees' => $this->getTotalFees(),
            'total_price' => $this->getTotalPrice()
        ];
    }
}
