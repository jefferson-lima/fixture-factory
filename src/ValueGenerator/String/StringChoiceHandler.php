<?php

namespace Jefferson\Lima\ValueGenerator\String;

use Jefferson\Lima\Reflection\DocTypedReflectionProperty;
use Jefferson\Lima\Reflection\AnnotationHandler;
use Symfony\Component\Validator\Constraints\Choice;

class StringChoiceHandler extends AnnotationHandler
{
    public function handle(DocTypedReflectionProperty $property, $value)
    {
        $annotation = $property->getAnnotation(Choice::class);

        if ($annotation) {

            if ($annotation->choices) {
                return $this->randomDataProvider->getElementOf($annotation->choices);
            }

            if ($annotation->callback) {
                return $this->randomDataProvider->getElementOf(call_user_func($annotation->callback));
            }

        }

        return $this->handleNext($property, $value);
    }
}
