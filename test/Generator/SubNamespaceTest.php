<?php
namespace Hostnet\Component\AccessorGenerator\Generator;

use Hostnet\Component\AccessorGenerator\Generator\fixtures\SubNamespace;

class SubNamespaceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException \BadMethodCallException
     */
    public function testGetAsterixTooManyArguments()
    {
        $subnamespace = new SubNamespace();
        $subnamespace->getAsterix(1);
    }

    /**
     * @expectedException \LogicException
     */
    public function testGetAsterixEmpty()
    {
        $subnamespace = new SubNamespace();
        $property     = new \ReflectionProperty($subnamespace, 'asterix');
        $property->setAccessible(true);
        $property->setValue($subnamespace, null);
        $subnamespace->getAsterix();
    }

    /**
     * @expectedException \BadMethodCallException
     */
    public function testSetAsterixTooManyArguments()
    {
        $subnamespace = new SubNamespace();
        $subnamespace->setAsterix('1', 2);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testSetAsterixInvalidArgument()
    {
        $subnamespace = new SubNamespace();
        $subnamespace->setAsterix([]);
    }

    public function testSetAsterix()
    {
        $subnamespace = new SubNamespace();
        self::assertSame($subnamespace, $subnamespace->setAsterix('panoramix'));
        self::assertEquals('panoramix', $subnamespace->getAsterix());
    }

    /**
     * @expectedException \BadMethodCallException
     */
    public function testSetSuperNamespaceTooManyArguments()
    {
        $subnamespace = new SubNamespace();
        $subnamespace->setSuperNamespace('1', 2);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testSetSuperNamespaceInvalidArgument()
    {
        $subnamespace = new SubNamespace();
        $subnamespace->setSuperNamespace([]);
    }

    public function testSetSuperNamespace()
    {
        $subnamespace = new SubNamespace();
        self::assertSame($subnamespace, $subnamespace->setSuperNamespace('panoramix'));
        self::assertEquals('panoramix', $subnamespace->super_namespace);
    }
}
