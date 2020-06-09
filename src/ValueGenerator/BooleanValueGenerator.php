<?php

namespace Jefferson\Lima\ValueGenerator;

use Jefferson\Lima\Reflection\DocTypedReflectionProperty;
use Symfony\Component\Validator\Constraints\NotBlank;

class BooleanValueGenerator extends ValueGenerator
{
    /**
     * @inheritDoc
     */
    public function generate(DocTypedReflectionProperty $property, $object)
    {
        return $property->getAnnotation(NotBlank::class) !== null;
    }
}
