<?php

namespace App\Service;

use App\Entity\Vehicle;
use App\Service\Fee\StorageFee;
use App\Service\Fee\BasicBuyerFee;
use App\Service\Fee\SellerSpecialFee;
use App\Service\Fee\AssociationFee;

class VehicleService
{
    private ConfigLoaderService $configLoaderService;

    public function __construct(ConfigLoaderService $configLoaderService)
    {
        $this->configLoaderService = $configLoaderService;
    }
    public function getVehicleWithCost(int $basePrice, String $type): Vehicle
    {
        $vehicle = new Vehicle($basePrice, $type);

        $storageFee = new StorageFee($this->configLoaderService->getFeeConfig('storage_fee'));
        $basicBuyerFee = new BasicBuyerFee($this->configLoaderService->getFeeConfig('basic_buyer_fee'));
        $sellerSpecialFee = new SellerSpecialFee($this->configLoaderService->getFeeConfig('seller_special_fee'));
        $associationFee = new AssociationFee($this->configLoaderService->getFeeConfig('association_fee'));

        $basicBuyerFee->applyFee($vehicle);
        $sellerSpecialFee->applyFee($vehicle);
        $associationFee->applyFee($vehicle);
        $storageFee->applyFee($vehicle);

        return $vehicle;
    }
}
