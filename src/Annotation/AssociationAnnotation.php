<?php

namespace Jefferson\Lima\Annotation;

use Doctrine\ORM\Mapping\Annotation;
use Doctrine\ORM\Mapping\ManyToMany;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\OneToOne;
use Jefferson\Lima\FixtureFactoryException;
use Jefferson\Lima\Reflection\ClassNameResolver;
use Jefferson\Lima\Reflection\DocTypedReflectionProperty;
use phpDocumentor\Reflection\Types\Context;
use ReflectionException;

class AssociationAnnotation
{
    private const ASSOCIATION_ANNOTATIONS = [
      OneToOne::class,
      ManyToOne::class,
      OneToMany::class,
      ManyToMany::class
    ];

    /** @var Annotation */
    private $annotation;

    /** @var Context */
    private $context;

    public function __construct(Annotation $annotation, Context $context)
    {
        $annotationClass = get_class($annotation);
        if (!in_array($annotationClass, static::ASSOCIATION_ANNOTATIONS, true)) {
            throw new FixtureFactoryException("$annotationClass is not an association annotation");
        }

        $this->annotation = $annotation;
        $this->context = $context;
    }

    public function getTargetEntity(): string
    {
        if (strpos($this->annotation->targetEntity, '\\')) {
            return ClassNameResolver::resolve('\\' . $this->annotation->targetEntity, new Context(''));
        }

        return ClassNameResolver::resolve($this->annotation->targetEntity, $this->context);
    }

    /**
     * @return DocTypedReflectionProperty|null
     * @throws ReflectionException
     */
    public function getTargetProperty(): ?DocTypedReflectionProperty
    {
        $targetPropertyValue = $this->annotation->inversedBy ?? $this->annotation->mappedBy ?? null;
        $targetProperty = null;

        if ($targetPropertyValue) {
            try {
                $targetProperty = new DocTypedReflectionProperty($this->getTargetEntity(), $targetPropertyValue);
            } catch (ReflectionException $ex) {
                throw new FixtureFactoryException(
                    "The target entity '{$this->getTargetEntity()}' doesn't have the property '$targetPropertyValue'"
                );
            }
        }

        return $targetProperty;
    }
}
