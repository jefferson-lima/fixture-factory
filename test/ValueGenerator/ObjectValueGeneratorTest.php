<?php

namespace Jefferson\Lima\Test\ValueGenerator;

use Doctrine\ORM\Mapping\OneToOne;
use Jefferson\Lima\FixtureFactoryException;
use Jefferson\Lima\Reflection\DocTypedReflectionProperty;
use Jefferson\Lima\Test\TestObject\OneToOneA;
use Jefferson\Lima\Test\TestObject\OneToOneB;
use Jefferson\Lima\ValueGenerator\Object\ObjectValueGenerator;
use PHPUnit\Framework\TestCase;

class ObjectValueGeneratorTest extends TestCase
{
    /** @var ObjectValueGenerator */
    private $objectGenerator;

    /**
     * @var OneToOneB
     * @OneToOne(targetEntity="OneToOneB")
     */
    private $oneToOneWithoutInversedBy;

    protected function setUp(): void
    {
        $this->objectGenerator = new ObjectValueGenerator();
    }

    public function testOneToOne(): void
    {
        $initialObject = new OneToOneA();
        $property = new DocTypedReflectionProperty(OneToOneA::class, 'oneToOneWithInversedBy');
        $object = $this->objectGenerator->generate($property, $initialObject);

        $this->assertInstanceOf(OneToOneB::class, $object);
        $this->assertEquals($initialObject, $object->getOneToOneA());
    }

    public function testOneToOneWithoutInversedBy(): void
    {
        $this->expectException(FixtureFactoryException::class);
        $property = new DocTypedReflectionProperty(__CLASS__, 'oneToOneWithoutInversedBy');
        $this->objectGenerator->generate($property, new OneToOneA());
    }
}
