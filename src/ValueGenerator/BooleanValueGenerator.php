<?php

namespace Jefferson\Lima\ValueGenerator;

use Doctrine\Common\Annotations\AnnotationReader;
use ReflectionProperty;
use Symfony\Component\Validator\Constraints\NotBlank;

class BooleanValueGenerator
{
    public function generate(ReflectionProperty $property): bool
    {
        $value = false;

        $annotationReader = new AnnotationReader();
        $notBlankAnnotation = $annotationReader->getPropertyAnnotation($property, NotBlank::class);

        if ($notBlankAnnotation) {
            $value = true;
        }

        return $value;
    }
}
