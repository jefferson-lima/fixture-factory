<?php

namespace Jefferson\Lima\Reflection;

use phpDocumentor\Reflection\Types\Object_;
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

    /**
     * @return array
     */
    public function getObjectProperties(): array
    {
        $objProperties = array_filter(
            $this->getDocProperties(),
            static function (DocTypedReflectionProperty $property) {
                return $property->getVarType() instanceof Object_;
            }
        );

        return array_values($objProperties);
    }
}
