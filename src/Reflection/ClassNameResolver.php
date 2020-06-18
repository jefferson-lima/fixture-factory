<?php

namespace Jefferson\Lima\Reflection;

use phpDocumentor\Reflection\FqsenResolver;
use phpDocumentor\Reflection\Types\ContextFactory;
use Reflector;

class ClassNameResolver
{
    public static function resolve(string $className, Reflector $reflectorContext): string
    {
        $fqsenResolver = new FqsenResolver();
        $contextFactory = new ContextFactory();
        $context = $contextFactory->createFromReflector($reflectorContext);
        $className = $fqsenResolver->resolve($className, $context);
        return ltrim($className, '\\');
    }
}
