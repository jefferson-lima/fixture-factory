<?php

namespace Jefferson\Lima\ValueGenerator\Object;

use Doctrine\ORM\Mapping\OneToOne;
use Jefferson\Lima\FixtureFactory;
use Jefferson\Lima\FixtureFactoryException;
use Jefferson\Lima\Reflection\AnnotationHandler;
use Jefferson\Lima\Reflection\DocTypedReflectionProperty;
use phpDocumentor\Reflection\FqsenResolver;
use phpDocumentor\Reflection\Types\ContextFactory;
use ReflectionProperty;

class OneToOneHandler extends AnnotationHandler
{
    public function handle(DocTypedReflectionProperty $property, $value, $object)
    {
        $annotation = $property->getAnnotation(OneToOne::class);

        if ($annotation) {

            if ($annotation->inversedBy === null) {
                throw new FixtureFactoryException('A OneToOne association must specify the inversedBy property');
            }

            $fqsenResolver = new FqsenResolver();
            $contextFactory = new ContextFactory();
            $context = $contextFactory->createFromReflector($property);
            $targetClass = $fqsenResolver->resolve($annotation->targetEntity, $context)->__toString();

            $targetObject = FixtureFactory::createFixture($targetClass, [$annotation->inversedBy => null]);
            $reflectionProperty = new ReflectionProperty($targetClass, $annotation->inversedBy);
            $reflectionProperty->setAccessible(true);
            $reflectionProperty->setValue($targetObject, $object);

            return $targetObject;
        }

        return $this->handleNext($property, $value, $object);
    }
}
