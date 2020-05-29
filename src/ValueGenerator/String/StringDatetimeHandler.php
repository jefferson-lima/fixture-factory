<?php

namespace Jefferson\Lima\ValueGenerator\String;

use Jefferson\Lima\Reflection\DocTypedReflectionProperty;
use Jefferson\Lima\Reflection\AnnotationHandler;
use Symfony\Component\Validator\Constraints\DateTime;

class StringDatetimeHandler extends AnnotationHandler
{
    public const DEFAULT_DATETIME_FORMAT = 'Y-m-d H:i:s';

    public function handle(DocTypedReflectionProperty $property, $value)
    {
        $annotation = $property->getAnnotation(DateTime::class);

        if ($annotation) {
            $format = $annotation->format ?? static::DEFAULT_DATETIME_FORMAT;
            return $this->randomDataProvider->getDatetimeString($format);
        }

        return $this->handleNext($property, $value);
    }
}
