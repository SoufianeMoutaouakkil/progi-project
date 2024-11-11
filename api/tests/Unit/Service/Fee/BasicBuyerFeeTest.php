<?php

namespace App\Tests\Unit\Service\Fee;

use App\Service\Fee\BasicBuyerFee;
use App\Entity\Vehicle;

class BasicBuyerFeeTest extends \PHPUnit\Framework\TestCase
{
    private $configExample = [
        'fee' => 0.10,
        'min' => [
            'common' => 10,
            'luxury' => 25,
        ],
        'max' => [
            'common' => 50,
            'luxury' => 200,
        ],
    ];

    public function feesDataProvider(): array
    {
        return [
            [new Vehicle(398.0, Vehicle::TYPE_COMMON), 39.8],
            [new Vehicle(501.0, Vehicle::TYPE_COMMON), 50],
            [new Vehicle(57.0, Vehicle::TYPE_COMMON), 10],
            [new Vehicle(1_800.0, Vehicle::TYPE_LUXURY), 180],
            [new Vehicle(1_100.0, Vehicle::TYPE_COMMON), 50],
            [new Vehicle(1_000_000.0, Vehicle::TYPE_LUXURY), 200],
        ];
    }

    /**
     * @dataProvider feesDataProvider
     */
    public function testFeeCalculation(Vehicle $vehicle, float $expectedBasicBuyerFee): void
    {
        $basicBuyerFee = new BasicBuyerFee($this->configExample);
        $basicBuyerFee->applyFee($vehicle);
        $this->assertSame($expectedBasicBuyerFee, $vehicle->getBasicBuyerFee());
    }

    public function testNotEnabledFee(): void
    {
        $vehicle = new Vehicle(398.0, Vehicle::TYPE_COMMON);
        $configExample = $this->configExample;
        $configExample['enabled'] = false;

        $basicBuyerFee = new BasicBuyerFee($configExample);
        $basicBuyerFee->applyFee($vehicle);
        $this->assertSame(0.0, $vehicle->getBasicBuyerFee());
    }

    public function testInvalidConfigFormat(): BasicBuyerFee
    {
        $this->expectException(\App\Exception\BusinessLogicException::class);

        $invalidConfigFormat = [
            'fee' => 0.10,
        ];

        return new BasicBuyerFee($invalidConfigFormat);
    }

    public function testInvalidConfigVehicleType(): BasicBuyerFee
    {
        $this->expectException(\App\Exception\BusinessLogicException::class);

        $configExample = $this->configExample;
        $configExample['min']['invalid'] = 10;

        return new BasicBuyerFee($configExample);
    }

    public function testInvalidConfigFeeValue(): BasicBuyerFee
    {
        $this->expectException(\App\Exception\BusinessLogicException::class);

        $configExample = $this->configExample;
        $configExample['fee'] = 'invalid';

        return new BasicBuyerFee($configExample);
    }

    public function testInvalidConfigMinValue(): BasicBuyerFee
    {
        $this->expectException(\App\Exception\BusinessLogicException::class);

        $configExample = $this->configExample;
        $configExample['min']['common'] = 'invalid';

        return new BasicBuyerFee($configExample);
    }
}
