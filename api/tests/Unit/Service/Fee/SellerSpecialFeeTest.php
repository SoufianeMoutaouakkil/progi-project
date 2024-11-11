<?php

namespace App\Tests\Unit\Service\Fee;

use App\Service\Fee\SellerSpecialFee;
use App\Entity\Vehicle;

class SellerSpecialFeeTest extends \PHPUnit\Framework\TestCase
{
    private $configExample = [
        'fee' => [
            'common' => 0.02,
            'luxury' => 0.04,
        ],
    ];

    public function feesDataProvider(): array
    {
        return [
            [new Vehicle(398.0, Vehicle::TYPE_COMMON), 7.96],
            [new Vehicle(501.0, Vehicle::TYPE_COMMON), 10.02],
            [new Vehicle(57.0, Vehicle::TYPE_COMMON), 1.14],
            [new Vehicle(1_800.0, Vehicle::TYPE_LUXURY), 72],
            [new Vehicle(1_100.0, Vehicle::TYPE_COMMON), 22],
            [new Vehicle(1_000_000.0, Vehicle::TYPE_LUXURY), 40_000],
        ];
    }

    /**
     * @dataProvider feesDataProvider
     */
    public function testFeeCalculation(Vehicle $vehicle, float $expectedSellerSpecialFee): void
    {
        $sellerSpecialFee = new SellerSpecialFee($this->configExample);
        $sellerSpecialFee->applyFee($vehicle);
        $this->assertSame($expectedSellerSpecialFee, $vehicle->getSellerSpecialFee());
    }

    public function testInvalidConfigFormat(): SellerSpecialFee
    {
        $this->expectException(\App\Exception\BusinessLogicException::class);

        $invalidConfigFormat = [
            'fee' => 0.10,
        ];

        return new SellerSpecialFee($invalidConfigFormat);
    }

    public function testInvalidConfigVehicleType(): SellerSpecialFee
    {
        $this->expectException(\App\Exception\BusinessLogicException::class);

        $configExample = $this->configExample;
        $configExample['fee']['invalid'] = 0.02;

        return new SellerSpecialFee($configExample);
    }

    public function testInvalidConfigFeeValue(): SellerSpecialFee
    {
        $this->expectException(\App\Exception\BusinessLogicException::class);

        $configExample = $this->configExample;
        $configExample['fee'][Vehicle::TYPE_COMMON] = 'invalid';

        return new SellerSpecialFee($configExample);
    }
}
