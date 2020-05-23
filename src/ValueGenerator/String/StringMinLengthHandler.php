<?php

namespace Jefferson\Lima\ValueGenerator\String;

use Faker\Provider\Lorem;
use Jefferson\Lima\Reflection\DocTypedReflectionProperty;
use Jefferson\Lima\Reflection\PropertyAnnotationHandler;
use Symfony\Component\Validator\Constraints\Length;

class StringMinLengthHandler extends PropertyAnnotationHandler
{
    public function handle(DocTypedReflectionProperty $property, $value)
    {
        $lengthAnnotation = $property->getAnnotation(Length::class);

        if ($lengthAnnotation && $lengthAnnotation->min) {
            while (strlen($value) < $lengthAnnotation->min) {
                $value .= ' ' . Lorem::word();
            }
        }

        return $this->handleNext($property, $value);
    }
}
