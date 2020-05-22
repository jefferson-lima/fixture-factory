<?php

namespace Jefferson\Lima\Reflection;

use Doctrine\Common\Annotations\AnnotationReader;
use phpDocumentor\Reflection\DocBlock;
use phpDocumentor\Reflection\Types\Compound;
use ReflectionException;
use ReflectionProperty;
use phpDocumentor\Reflection\DocBlockFactory;
use phpDocumentor\Reflection\DocBlock\Tags\Var_;

/**
 * Class DocTypedReflectionProperty extends the ReflectionProperty class with the
 * ability  of reading the property's type from the docblock '@var' tag.
 *
 * @package Jefferson\Lima\Reflection
 */
class DocTypedReflectionProperty extends ReflectionProperty
{
    private const VAR_TAG = 'var';

    /** @var  AnnotationReader */
    private $annotationReader;

    /** @var DocBlock */
    private $docBlock;

    public function __construct(string $class, string $propertyName)
    {
        parent::__construct($class, $propertyName);
        $this->docBlock = $this->getDocBlock();
        $this->annotationReader = new AnnotationReader();
    }

    /**
     * @param ReflectionProperty $property
     * @return DocTypedReflectionProperty
     * @throws ReflectionException
     */
    public static function createFromReflectionProperty(ReflectionProperty $property): DocTypedReflectionProperty
    {
        return new DocTypedReflectionProperty($property->getDeclaringClass()->getName(), $property->getName());
    }

    private function getDocBlock(): ?DocBlock
    {
        $docblockFactory = DocBlockFactory::createInstance();
        $docComment = $this->getDocComment();

        return $docComment ? $docblockFactory->create($docComment) : null;
    }

    public function setValue($objectOrValue, $value = null)
    {
        $this->setAccessible(true);
        parent::setValue($objectOrValue, $value);
    }

    /**
     * Checks if the property has a valid '@var' tag.
     *
     * @return bool
     */
    public function hasVarType(): bool
    {
        $hasVarTag = false;

        if ($this->docBlock) {
            $varTags = $this->docBlock->getTagsByName(static::VAR_TAG);
            $hasVarTag = count($varTags) > 0 && $varTags[0] instanceof Var_;
        }

        return $hasVarTag;
    }

    /**
     * Return the first type of the '@var' tag, if there's one.
     *
     * @return string|null
     */
    public function getVarType(): ?string
    {
        if (!$this->hasVarType()) {
            return null;
        }

        $varTags = $this->docBlock->getTagsByName(static::VAR_TAG);
        $varTag = $varTags[0];
        $varTagType = $varTag->getType();

        if ($varTagType instanceof Compound) {
            $varTagType = $varTagType->get(0);
        }

        return $varTagType->__toString();
    }

    /**
     * @param string $annotationClass
     * @return object|null
     */
    public function getAnnotation(string $annotationClass)
    {
        return $this->annotationReader->getPropertyAnnotation($this, $annotationClass);
    }
}
