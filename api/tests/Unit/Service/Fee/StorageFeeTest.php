<?php

namespace App\Tests\Unit\Service\Fee;

use App\Service\Fee\StorageFee;
use App\Entity\Vehicle;

class StorageFeeTest extends \PHPUnit\Framework\TestCase
{
    private $configExample = [
        'fee' => 100.0,
    ];

    public function feesDataProvider(): array
    {
        return [
            [new Vehicle(398.0, Vehicle::TYPE_COMMON), 100],
            [new Vehicle(501.0, Vehicle::TYPE_COMMON), 100],
            [new Vehicle(57.0, Vehicle::TYPE_COMMON), 100],
            [new Vehicle(1_800.0, Vehicle::TYPE_LUXURY), 100],
            [new Vehicle(1_100.0, Vehicle::TYPE_COMMON), 100],
            [new Vehicle(1_000_000.0, Vehicle::TYPE_LUXURY), 100],
        ];
    }

    /**
     * @dataProvider feesDataProvider
     */
    public function testFeeCalculation(Vehicle $vehicle, float $expectedStorageFee): void
    {
        $storageFee = new StorageFee($this->configExample);
        $storageFee->applyFee($vehicle);
        $this->assertSame($expectedStorageFee, $vehicle->getStorageFee());
    }

    public function testInvalidConfigFormat(): StorageFee
    {
        $this->expectException(\App\Exception\BusinessLogicException::class);

        $invalidConfigFormat = [
            'invalid_key' => 100,
        ];

        return new StorageFee($invalidConfigFormat);
    }

    public function testInvalidConfigFeeValue(): StorageFee
    {
        $this->expectException(\App\Exception\BusinessLogicException::class);

        $configExample = [
            'fee' => 'invalid',
        ];

        return new StorageFee($configExample);
    }
}
