<?php

namespace Jefferson\Lima\ValueGenerator;

use Jefferson\Lima\Reflection\DocTypedReflectionProperty;
use Symfony\Component\Validator\Constraints\NotBlank;

class BooleanValueGenerator implements ValueGenerator
{
    /**
     * @inheritDoc
     */
    public function generate(DocTypedReflectionProperty $property)
    {
        return $property->getAnnotation(NotBlank::class) !== null;
    }
}
