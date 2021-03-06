<?php

namespace Jefferson\Lima\ValueGenerator\String;

use Jefferson\Lima\Reflection\DocTypedReflectionProperty;
use Jefferson\Lima\Annotation\AnnotationHandler;
use Symfony\Component\Validator\Constraints\Regex;

class StringRegexHandler extends AnnotationHandler
{
    public function handle(DocTypedReflectionProperty $property, $value, $object)
    {
        $regexAnnotation = $property->getAnnotation(Regex::class);

        if ($regexAnnotation) {
            $pattern = $regexAnnotation->pattern;
            return $this->randomDataProvider->getRegex($pattern);
        }

        return $this->handleNext($property, $value, $object);
    }
}
