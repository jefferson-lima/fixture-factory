<?php

namespace Jefferson\Lima\Reflection;

use ReflectionClass;
use ReflectionProperty;

class DocTypedReflectionClass extends ReflectionClass
{
    public function getDocProperties($filter = null): array
    {
        return array_map(function (ReflectionProperty $property) {
            return DocTypedReflectionProperty::createFromReflectionProperty($property);
        }, $this->getProperties($filter));
    }
}
