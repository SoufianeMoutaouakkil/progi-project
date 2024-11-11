<?php

namespace App\Tests\Unit\Entity;

use App\Entity\Vehicle;

class VehicleTest extends \PHPUnit\Framework\TestCase
{
    public function testValidVehicleType(): void
    {
        $this->assertTrue(Vehicle::isValidVehicleType(Vehicle::TYPE_COMMON));
        $this->assertTrue(Vehicle::isValidVehicleType(Vehicle::TYPE_LUXURY));
    }

    public function testInvalidVehicleType(): void
    {
        $this->assertFalse(Vehicle::isValidVehicleType('invalid'));
    }

    public function testBasePrice(): void
    {
        $vehicle = new Vehicle(1000.0, Vehicle::TYPE_COMMON);
        $this->assertSame(1000.0, $vehicle->getBasePrice());
    }

    public function testNegativeBasePrice(): Vehicle
    {
        $this->expectException(\App\Exception\BusinessLogicException::class);
        $this->expectExceptionMessage('Base price must be a positive number');

        return new Vehicle(-1000.0, Vehicle::TYPE_COMMON);
    }

    public function testInvalidVehicleTypeOnConstruction(): Vehicle
    {
        $this->expectException(\App\Exception\BusinessLogicException::class);
        $this->expectExceptionMessage('Invalid vehicle type');

        return new Vehicle(1000.0, 'invalid');
    }
}
