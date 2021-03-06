<?php
namespace Hostnet\Component\AccessorGenerator\Generator;

use Hostnet\Component\AccessorGenerator\Generator\fixtures\Bicycle;
use Hostnet\Component\AccessorGenerator\Generator\fixtures\Boat;
use Hostnet\Component\AccessorGenerator\Generator\fixtures\Car;
use Hostnet\Component\AccessorGenerator\Generator\fixtures\PracticalVehicleOwner;
use Hostnet\Component\AccessorGenerator\Generator\fixtures\VehicleInterface;

/**
 * @covers \Hostnet\Component\AccessorGenerator\Generator\fixtures\Generated\PracticalVehicleOwnerMethodsTrait
 */
class PracticalVehicleOwnerTest extends \PHPUnit_Framework_TestCase
{
    public function testAddVehicle()
    {
        $boat = new Boat();
        $car  = new Car();

        $owner = new PracticalVehicleOwner();
        $owner->addVehicle($boat)->addVehicle($car);

        self::assertSame([$boat, $car], $owner->vehicles->toArray());
    }

    /**
     * @expectedException \Hostnet\Component\AccessorGenerator\Exception\MissingPropertyException
     */
    public function testAddWrongVehicle()
    {

        $owner = new PracticalVehicleOwner();
        $owner->addVehicle($this->prophesize(VehicleInterface::class)->reveal());
    }

    public function testAddCustomVehicle()
    {
        $owner   = new PracticalVehicleOwner();
        $bicycle = new Bicycle();
        $owner->addVehicle($bicycle)->addVehicle($bicycle);
    }

    /**
     * @expectedException \BadMethodCallException
     */
    public function testAddVehicleTooManyArguments()
    {
        $car   = new Car();
        $owner = new PracticalVehicleOwner();
        $owner->addVehicle($car, $car);
    }

    /**
     * @expectedException \LogicException
     */
    public function testAddVehicleToMultipleOwners()
    {
        $owner = new PracticalVehicleOwner();
        $thief = new PracticalVehicleOwner();

        $bicycle = new Bicycle();

        $owner->addVehicle($bicycle);
        $thief->addVehicle($bicycle);
    }
}
