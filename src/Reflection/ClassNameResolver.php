<?php

namespace Jefferson\Lima\Reflection;

use phpDocumentor\Reflection\FqsenResolver;
use phpDocumentor\Reflection\Types\Context;

class ClassNameResolver
{
    public static function resolve(string $className, Context $context): string
    {
        $fqsenResolver = new FqsenResolver();
        $className = $fqsenResolver->resolve($className, $context);
        return ltrim($className, '\\');
    }
}
