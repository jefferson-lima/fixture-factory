<?php

namespace Jefferson\Lima\ValueGenerator\String;

use Jefferson\Lima\Reflection\DocTypedReflectionProperty;
use Jefferson\Lima\Reflection\PropertyAnnotationHandler;
use Symfony\Component\Validator\Constraints\Url;

class StringUrlHandler extends PropertyAnnotationHandler
{
    public function handle(DocTypedReflectionProperty $property, $value)
    {
        $annotation = $property->getAnnotation(Url::class);
        return $annotation ? $this->faker->url : $this->handleNext($property, $value);
    }
}
