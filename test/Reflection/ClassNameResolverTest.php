<?php

namespace Jefferson\Lima\Test\Reflection;

use Jefferson\Lima\Reflection\ClassNameResolver;
use phpDocumentor\Reflection\Types\ContextFactory;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

class ClassNameResolverTest extends TestCase
{
    public function testResolve(): void
    {
        $contextFactory = new ContextFactory();
        $context = $contextFactory->createFromReflector(new ReflectionClass(__CLASS__));

        $this->assertEquals(
            TestCase::class,
            ClassNameResolver::resolve('TestCase', $context)
        );
    }
}