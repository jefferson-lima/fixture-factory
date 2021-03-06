<?php

namespace Jefferson\Lima\ValueGenerator\Object;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping\OneToMany;
use Jefferson\Lima\Reflection\DocTypedReflectionProperty;

class OneToManyHandler extends AssociationHandler
{
    public function handle(DocTypedReflectionProperty $property, $value, $object)
    {
        $annotation = $property->getAssociationAnnotation(OneToMany::class);

        if ($annotation) {
            $collection = new ArrayCollection();

            for ($i = 0; $i < static::COLLECTION_SIZE; $i++) {
                $targetObject = $this->createTargetObject($annotation, $object);
                $collection->add($targetObject);
            }

            return $collection;
        }

        return $this->handleNext($property, $value, $object);
    }


}
