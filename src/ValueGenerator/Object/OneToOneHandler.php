<?php

namespace Jefferson\Lima\ValueGenerator\Object;

use Doctrine\ORM\Mapping\Annotation;
use Doctrine\ORM\Mapping\OneToOne;
use Jefferson\Lima\FixtureFactory;
use Jefferson\Lima\FixtureFactoryException;
use Jefferson\Lima\Reflection\AnnotationHandler;
use Jefferson\Lima\Reflection\DocTypedReflectionProperty;
use phpDocumentor\Reflection\FqsenResolver;
use phpDocumentor\Reflection\Types\ContextFactory;
use ReflectionException;
use ReflectionProperty;

class OneToOneHandler extends AnnotationHandler
{
    public function handle(DocTypedReflectionProperty $property, $value, $object)
    {
        $annotation = $property->getAnnotation(OneToOne::class);

        if ($annotation) {
            $targetProperty = $annotation->inversedBy ?? $annotation->mappedBy;
            $targetClass = $this->resolveTargetClass($property, $annotation);
            $targetObject = FixtureFactory::createFixture($targetClass, [$targetProperty => null]);

            if ($targetProperty) {
                $reflectionProperty = $this->createReflectionProperty($targetClass, $targetProperty);
                $reflectionProperty->setAccessible(true);
                $reflectionProperty->setValue($targetObject, $object);
            }

            return $targetObject;
        }

        return $this->handleNext($property, $value, $object);
    }

    /**
     * @param DocTypedReflectionProperty $property
     * @param Annotation $annotation
     * @return string
     */
    private function resolveTargetClass(DocTypedReflectionProperty $property, Annotation $annotation): string
    {
        $fqsenResolver = new FqsenResolver();
        $contextFactory = new ContextFactory();
        $context = $contextFactory->createFromReflector($property);
        return $fqsenResolver->resolve($annotation->targetEntity, $context)->__toString();
    }

    /**
     * @param string $targetClass
     * @param $targetProperty
     * @return ReflectionProperty
     */
    private function createReflectionProperty(string $targetClass, $targetProperty): ReflectionProperty
    {
        try {
            $reflectionProperty = new ReflectionProperty($targetClass, $targetProperty);
        } catch (ReflectionException $e) {
            throw new FixtureFactoryException('Invalid property on target entity', 0, $e);
        }
        return $reflectionProperty;
    }
}
