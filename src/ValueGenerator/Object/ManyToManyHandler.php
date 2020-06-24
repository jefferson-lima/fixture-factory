<?php

namespace Jefferson\Lima\ValueGenerator\Object;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping\ManyToMany;
use Doctrine\ORM\Mapping\OneToMany;
use Jefferson\Lima\Reflection\DocTypedReflectionProperty;

class ManyToManyHandler extends AssociationHandler
{
    public function handle(DocTypedReflectionProperty $property, $value, $object)
    {
        $annotation = $property->getAssociationAnnotation(ManyToMany::class);

        if ($annotation) {
            $collection = new ArrayCollection();

            $objectCollection = new ArrayCollection([$object]);

            for ($i = 0; $i < static::COLLECTION_SIZE; $i++) {
                $targetObject = $this->createTargetObject($annotation, $objectCollection);
                $collection->add($targetObject);
            }

            return $collection;
        }

        return $this->handleNext($property, $value, $object);
    }


}
