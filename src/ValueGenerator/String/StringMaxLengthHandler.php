<?php

namespace Jefferson\Lima\ValueGenerator\String;

use Jefferson\Lima\Reflection\DocTypedReflectionProperty;
use Jefferson\Lima\Reflection\AnnotationHandler;
use Symfony\Component\Validator\Constraints\Length;

class StringMaxLengthHandler extends AnnotationHandler
{
    public function handle(DocTypedReflectionProperty $property, $value)
    {
        $lengthAnnotation = $property->getAnnotation(Length::class);
        $max = $lengthAnnotation ? $lengthAnnotation->max : null;

        if ($max && strlen($value) > $max) {
            $value = substr($value, 0, $max);
        }

        return $this->handleNext($property, $value);
    }
}
