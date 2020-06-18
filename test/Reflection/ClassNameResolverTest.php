<?php

namespace Jefferson\Lima\Test\Reflection;

use Jefferson\Lima\Reflection\ClassNameResolver;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

class ClassNameResolverTest extends TestCase
{
    public function testResolve(): void
    {
        $this->assertEquals(
            TestCase::class,
            ClassNameResolver::resolve('TestCase', new ReflectionClass(__CLASS__))
        );
    }
}