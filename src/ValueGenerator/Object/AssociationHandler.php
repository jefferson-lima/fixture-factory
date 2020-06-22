<?php

namespace Jefferson\Lima\ValueGenerator\Object;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping\OneToMany;
use Jefferson\Lima\Annotation\AnnotationHandler;
use Jefferson\Lima\Annotation\AssociationAnnotation;
use Jefferson\Lima\FixtureFactory;
use Jefferson\Lima\Reflection\DocTypedReflectionProperty;
use ReflectionException;

abstract class AssociationHandler extends AnnotationHandler
{
    /**
     * @param AssociationAnnotation $annotation
     * @param $object
     * @return object
     * @throws ReflectionException
     */
    protected function createTargetObject(AssociationAnnotation $annotation, $object)
    {
        $targetProperty = $annotation->getTargetProperty();
        $targetPropertyName = $targetProperty ? $targetProperty->getName() : null;
        $targetObject = FixtureFactory::createFixture($annotation->getTargetEntity(), [$targetPropertyName => null]);

        if ($targetProperty) {
            $targetProperty->setAccessible(true);
            $targetProperty->setValue($targetObject, $object);
        }
        return $targetObject;
    }
}
