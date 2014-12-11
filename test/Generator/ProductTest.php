<?php
namespace Hostnet\Component\AccessorGenerator\Generator;

use Doctrine\Common\Collections\Collection;
use Hostnet\Component\AccessorGenerator\Generator\fixtures\Attribute;
use Hostnet\Component\AccessorGenerator\Generator\fixtures\Period;
use Hostnet\Component\AccessorGenerator\Generator\fixtures\Product;

class ProductTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var Product
     */
    private $product;

    public function setUp()
    {
        $this->product = new Product();
    }

    public function testGetId()
    {
        $id = new \ReflectionProperty(Product::class, 'id');
        $id->setAccessible(true);
        $id->setValue($this->product, 10);

        $this->assertEquals(10, $this->product->getId());
    }

    /**
     * @expectedException \DomainException
     */
    public function testGetIdDomain()
    {
        $id = new \ReflectionProperty(Product::class, 'id');
        $id->setAccessible(true);
        $id->setValue($this->product, PHP_INT_MAX . '0');

        $this->product->getId();
    }

    /**
     * @expectedException \LogicException
     */
    public function testGetIdNew()
    {
        $this->assertNull($this->product->getId());
    }

    /**
     * @expectedException \BadMethodCallException
     */
    public function testGetIdTooManyArguments()
    {
        $this->product->getId(1);
    }

    public function testGetName()
    {
        $id = new \ReflectionProperty(Product::class, 'name');
        $id->setAccessible(true);
        $id->setValue($this->product, '10');

        $this->assertEquals('10', $this->product->getName());
        $this->assertTrue(is_string($this->product->getName()));
    }

    /**
     * @expectedException \LogicException
     */
    public function testGetNameNew()
    {
        $this->product->getName();
    }

    /**
     * @expectedException \BadMethodCallException
     */
    public function testGetNameTooManyArguments()
    {
        $this->product->getName(1);
    }

    public function testGetDescription()
    {
        $description = new \ReflectionProperty(Product::class, 'description');
        $description->setAccessible(true);
        $description->setValue($this->product, '10');

        $this->assertEquals('10', $this->product->getDescription());
        $this->assertTrue(is_string($this->product->getDescription()), 'of type string');
    }

    public function testGetDescriptionNew()
    {
        $this->assertEquals('empty', $this->product->getDescription());
    }

    /**
     * @expectedException \LogicException
     */
    public function testGetDescriptionNewNull()
    {
        $property = new \ReflectionProperty($this->product, 'description');
        $property->setAccessible(true);
        $property->setValue($this->product, null);
        $this->product->getDescription();
    }

    /**
     * @expectedException \BadMethodCallException
     */
    public function testGetDescriptionTooManyArguments()
    {
        $this->product->getDescription(1);
    }

    public function testSetSystemName()
    {
        $this->assertSame($this->product, $this->product->setSystemName('100'));
        $this->assertEquals('100', $this->product->getSystemName());
        $this->assertTrue(is_string($this->product->getSystemName()), 'of type string');
    }

    /**
     * @expectedException \BadMethodCallException
     */
    public function testSetSystemNameTooManyArguments()
    {
        $this->product->setSystemName('', 2);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testSetSystemNameWrongType()
    {
        $this->product->setSystemName(0);
    }

    /**
     * @expectedException \LengthException
     */
    public function testSetSystemNameTooLong()
    {
        $this->product->setSystemName(str_repeat('a', 51));
    }

    public function testGetSystemName()
    {
        $this->assertEmpty($this->product->getSystemName());
        $this->assertTrue(is_string($this->product->getSystemName()), 'of type string');
    }

    /**
     * @expectedException \LogicException
     */
    public function testGetSystemNameNewNull()
    {
        $property = new \ReflectionProperty($this->product, 'system_name');
        $property->setAccessible(true);
        $property->setValue($this->product, null);
        $this->product->getSystemName();
    }

    /**
     * @expectedException \BadMethodCallException
     */
    public function testGetSystemNameTooManyArguments()
    {
        $this->product->getSystemName(1);
    }

    public function testGetDuration()
    {
        $duration = new Period();
        $duration = new \ReflectionProperty(Product::class, 'duration');
        $duration->setAccessible(true);
        $duration->setValue($this->product, $duration);

        $this->assertSame($duration, $this->product->getDuration());
    }

    /**
     * @expectedException \Doctrine\ORM\EntityNotFoundException
     */
    public function testGetDurationEmpty()
    {
        $this->product->getDuration();
    }

    /**
     * @expectedException \BadMethodCallException
     */
    public function testGetDurationTooManyArguments()
    {
        $this->product->getDuration(1);
    }

    public function testGetAttributes()
    {
        $attributes = $this->product->getAttributes();
        $this->assertEmpty($attributes);
        $this->assertInstanceOf(Collection::class, $attributes);
    }

    /**
     * @expectedException \BadMethodCallException
     */
    public function testGetAttributesTooManyArguments()
    {
        $this->product->getAttributes(1);
    }

    /**
     * @depends testGetAttributes
     */
    public function testAddAttribute()
    {
        $attribute_a = new Attribute();
        $attribute_b = new Attribute();

        $this->product->addAttribute($attribute_a);
        $this->product->addAttribute($attribute_a);

        $attributes = $this->product->getAttributes();
        $this->assertCount(1, $attributes);

        $this->product->addAttribute($attribute_b);
        $this->assertCount(2, $attributes);

        $this->assertSame($attribute_a, $attributes->first());
        $this->assertSame($attribute_b, $attributes->last());
    }

    /**
     * @expectedException \BadMethodCallException
     */
    public function testAddAttributesTooManyArguments()
    {
        $attribute = new Attribute();
        $this->product->addAttribute($attribute, 2);
    }

    /**
     * @depends testAddAttribute
     * @depends testGetAttributes
     */
    public function testRemoveAttribute()
    {
        $attribute  = new Attribute();
        $attributes = $this->product->getAttributes();

        $this->product->addAttribute($attribute);
        $this->assertCount(1, $attributes);

        $this->product->removeAttribute($attribute);
        $this->product->removeAttribute($attribute);
        $this->assertCount(0, $attributes);
    }

    /**
     * @expectedException \BadMethodCallException
     */
    public function testRemoveAttributesTooManyArguments()
    {
        $attribute = new Attribute();
        $this->product->removeAttribute($attribute, 2);
    }
}