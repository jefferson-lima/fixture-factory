<?php

namespace Jefferson\Lima\ValueGenerator\Object;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping\ManyToOne;
use Jefferson\Lima\Annotation\AnnotationHandler;
use Jefferson\Lima\FixtureFactory;
use Jefferson\Lima\Reflection\DocTypedReflectionProperty;

class ManyToOneHandler extends AnnotationHandler
{
    private const COLLECTION_SIZE = 2;

    public function handle(DocTypedReflectionProperty $property, $value, $object)
    {
        $annotation = $property->getAssociationAnnotation(ManyToOne::class);

        if ($annotation) {
            $targetEntity = $annotation->getTargetEntity();
            $collection = new ArrayCollection();

            for ($i = 0; $i < static::COLLECTION_SIZE; $i++) {
                $collection->add(FixtureFactory::createFixture($targetEntity));
            }

            return $collection;
        }

        return $this->handleNext($property, $value, $object);
    }
}
