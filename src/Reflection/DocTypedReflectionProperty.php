<?php

namespace Jefferson\Lima\Reflection;

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\ORM\Mapping\Annotation;
use InvalidArgumentException;
use Jefferson\Lima\Annotation\AssociationAnnotation;
use phpDocumentor\Reflection\DocBlock;
use phpDocumentor\Reflection\Types\Compound;
use phpDocumentor\Reflection\Types\Context;
use phpDocumentor\Reflection\Types\ContextFactory;
use ReflectionException;
use ReflectionProperty;
use phpDocumentor\Reflection\DocBlockFactory;
use phpDocumentor\Reflection\DocBlock\Tags\Var_;
use phpDocumentor\Reflection\Type;

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

    /** @var Context */
    private $context;

    public function __construct(string $class, string $propertyName)
    {
        parent::__construct($class, $propertyName);

        $contextFactory = new ContextFactory();
        $this->context = $contextFactory->createFromReflector($this);

        $this->docBlock = $this->getDocBlock($this->context);
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

    private function getDocBlock(Context $context): ?DocBlock
    {
        try {
            $docblockFactory = DocBlockFactory::createInstance();

            $docComment = $this->getDocComment();

            return $docComment ? $docblockFactory->create($docComment, $context) : null;
        } catch (InvalidArgumentException $e) {
            return null;
        }
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
    public function getVarType(): ?Type
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

        return $varTagType;
    }

    /**
     * @param string $annotationClass
     * @return Annotation|null
     */
    public function getAnnotation(string $annotationClass)
    {
        return $this->annotationReader->getPropertyAnnotation($this, $annotationClass);
    }

    public function getAssociationAnnotation(string $annotationClass): ?AssociationAnnotation
    {
        $annotation = $this->getAnnotation($annotationClass);
        return $annotation ? new AssociationAnnotation($annotation, $this->context) : null;
    }

    public function getFqsen(): ?string
    {
        return $this->hasVarType() ? $this->getVarType()->getFqsen() : null;
    }
}
