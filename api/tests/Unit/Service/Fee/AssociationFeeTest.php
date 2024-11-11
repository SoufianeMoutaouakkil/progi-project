<?php

namespace App\Tests\Unit\Service\Fee;

use App\Service\Fee\AssociationFee;
use App\Entity\Vehicle;

class AssociationFeeTest extends \PHPUnit\Framework\TestCase
{
    private $configExample = [
        'steps' => [
            ['min' => 1, 'max' => 500, 'fee' => 5],
            ['min' => 501, 'max' => 1000, 'fee' => 10],
            ['min' => 1001, 'max' => 3000, 'fee' => 15],
            ['min' => 3001, 'max' => null, 'fee' => 20],
        ],
    ];

    public function feesDataProvider(): array
    {
        return [
            [new Vehicle(398.0, Vehicle::TYPE_COMMON), 5],
            [new Vehicle(501.0, Vehicle::TYPE_COMMON), 10],
            [new Vehicle(57.0, Vehicle::TYPE_COMMON), 5],
            [new Vehicle(1_800.0, Vehicle::TYPE_LUXURY), 15],
            [new Vehicle(1_100.0, Vehicle::TYPE_COMMON), 15],
            [new Vehicle(1_000_000.0, Vehicle::TYPE_LUXURY), 20],
        ];
    }

    /**
     * @dataProvider feesDataProvider
     */
    public function testFeeCalculation(Vehicle $vehicle, float $expectedAssociationFee): void
    {
        $associationFee = new AssociationFee($this->configExample);
        $associationFee->applyFee($vehicle);
        $this->assertSame($expectedAssociationFee, $vehicle->getAssociationFee());
    }

    public function testInvalidConfigFormat(): AssociationFee
    {
        $this->expectException(\App\Exception\BusinessLogicException::class);

        $invalidConfigFormat = [
            'invalid_key' => 100,
        ];

        // just to avoid sonarlint warning
        return new AssociationFee($invalidConfigFormat);
    }


    public function testInvalidConfigFeeValue(): AssociationFee
    {
        $this->expectException(\App\Exception\BusinessLogicException::class);

        $configExample = $this->configExample;
        $configExample['steps'][0]['fee'] = 'invalid';

        return new AssociationFee($configExample);
    }

    public function testInvalidConfigMinValue(): AssociationFee
    {
        $this->expectException(\App\Exception\BusinessLogicException::class);

        $configExample = $this->configExample;
        $configExample['steps'][0]['min'] = 'invalid';

        return new AssociationFee($configExample);
    }
}
