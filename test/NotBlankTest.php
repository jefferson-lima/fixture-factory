<?php

namespace Jefferson\Lima\Test;

use Jefferson\Lima\FixtureFactory;
use PHPUnit\Framework\TestCase;

class NotBlankTest extends TestCase
{
    public function testNotBlankString(): void
    {
        $fixture = FixtureFactory::createFixture(NotBlankTestObject::class);
        $this->assertTrue($fixture instanceof NotBlankTestObject);
        $this->assertTrue(is_string($fixture->getNotBlankStringAttr()));
        $this->assertFalse(empty($fixture->getNotBlankStringAttr()));
    }

    public function testNotBlankBoolean(): void
    {
        $this->markTestSkipped();
        $fixture = FixtureFactory::createFixture(NotBlankTestObject::class);
        $this->assertTrue($fixture instanceof NotBlankTestObject);
        $this->assertTrue(is_bool($fixture->isNotBlankBoolAttr()));
        $this->assertTrue($fixture->isNotBlankBoolAttr());
    }
}
