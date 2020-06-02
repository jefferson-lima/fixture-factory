<?php

namespace Jefferson\Lima\Test\Reflection;

use Jefferson\Lima\Reflection\DocTypedReflectionClass;
use Jefferson\Lima\Test\TestObject;
use PHPUnit\Framework\TestCase;

class DocTypedReflectionClassTest extends TestCase
{
    private $nonAnnotatedAttr;

    /** @var string */
    private $singleTypesAttr;

    /** @var TestObject  */
    private $objAttr;

    public function testGetObjectProperties(): void
    {
        $reflectionClass = new DocTypedReflectionClass(__CLASS__);
        $objProperties = $reflectionClass->getObjectProperties();

        $this->assertCount(1, $objProperties);
        $this->assertEquals('objAttr', $objProperties[0]->getName());
    }
}
