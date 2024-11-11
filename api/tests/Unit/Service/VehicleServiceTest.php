<?php

namespace App\Tests\Unit\Service;

use App\Service\ConfigLoaderService;
use App\Service\VehicleService;

class VehicleServiceTest extends \PHPUnit\Framework\TestCase
{

    private $configExample = [
        'association_fee' => [
            'steps' => [
                ['min' => 1, 'max' => 500, 'fee' => 5],
                ['min' => 501, 'max' => 1000, 'fee' => 10],
                ['min' => 1001, 'max' => 3000, 'fee' => 15],
                ['min' => 3001, 'max' => null, 'fee' => 20],
            ],
        ],
        'basic_buyer_fee' => [
            'fee' => 0.10,
            'min' => [
                'common' => 10,
                'luxury' => 25,
            ],
            'max' => [
                'common' => 50,
                'luxury' => 200,
            ],
        ],
        'seller_special_fee' => [
            'fee' => [
                'common' => 0.02,
                'luxury' => 0.04,
            ],
        ],
        'storage_fee' => [
            'fee' => 100,
        ],
    ];

    public function totalCostDataProvider(): array
    {
        return [
            [398.0, 'common', 550.76],
            [501.0, 'common', 671.02],
            [57.0, 'common', 173.14],
            [1_800.0, 'luxury', 2_167.0],
            [1_100.0, 'common', 1_287.0],
            [1_000_000.0, 'luxury', 1_040_320.0],
        ];
    }

    /**
     * @dataProvider totalCostDataProvider
     */
    public function testGetVehicleWithCosts($basePrice, $type, $expectedTotalCost): void
    {
        $configLoaderService = new ConfigLoaderService($this->configExample);

        $vehicleService = new VehicleService($configLoaderService);
        $vehicle = $vehicleService->getVehicleWithCosts($basePrice, $type);

        $this->assertSame($expectedTotalCost, $vehicle->getTotalPrice());
    }
}
