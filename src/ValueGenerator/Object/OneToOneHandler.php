<?php

namespace Jefferson\Lima\ValueGenerator\Object;

use Doctrine\ORM\Mapping\OneToOne;
use Jefferson\Lima\Annotation\AnnotationHandler;
use Jefferson\Lima\FixtureFactory;
use Jefferson\Lima\Reflection\DocTypedReflectionProperty;

class OneToOneHandler extends AnnotationHandler
{
    public function handle(DocTypedReflectionProperty $property, $value, $object)
    {
        $annotation = $property->getAssociationAnnotation(OneToOne::class);

        if ($annotation) {
            $targetProperty = $annotation->getTargetProperty();
            $targetPropertyName = $targetProperty ? $targetProperty->getName() : null;

            $targetObject = FixtureFactory::createFixture(
                $annotation->getTargetEntity(),
                [ $targetPropertyName => null]
            );

            if ($targetProperty) {
                $targetProperty->setAccessible(true);
                $targetProperty->setValue($targetObject, $object);
            }

            return $targetObject;
        }

        return $this->handleNext($property, $value, $object);
    }
}
