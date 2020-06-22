<?php

namespace Jefferson\Lima\ValueGenerator\Object;

use Doctrine\ORM\Mapping\OneToOne;
use Jefferson\Lima\Reflection\DocTypedReflectionProperty;

class OneToOneHandler extends AssociationHandler
{
    public function handle(DocTypedReflectionProperty $property, $value, $object)
    {
        $annotation = $property->getAssociationAnnotation(OneToOne::class);

        if ($annotation) {
            return $this->createTargetObject($annotation, $object);
        }

        return $this->handleNext($property, $value, $object);
    }
}
