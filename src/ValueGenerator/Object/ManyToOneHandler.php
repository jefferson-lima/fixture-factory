<?php

namespace Jefferson\Lima\ValueGenerator\Object;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping\ManyToOne;
use Jefferson\Lima\Reflection\DocTypedReflectionProperty;

class ManyToOneHandler extends AssociationHandler
{
    public function handle(DocTypedReflectionProperty $property, $value, $object)
    {
        $annotation = $property->getAssociationAnnotation(ManyToOne::class);

        if ($annotation) {
            $objectCollection = new ArrayCollection([$object]);
            return $this->createTargetObject($annotation, $objectCollection);
        }

        return $this->handleNext($property, $value, $object);
    }


}
