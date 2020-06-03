<?php

namespace Jefferson\Lima\Test\TestObject;

class CircularReferenceBackTestObject
{
    /** @var CircularReferenceTestObject */
    private $circularReference;

    /**
     * @return CircularReferenceTestObject
     */
    public function getCircularReference(): CircularReferenceTestObject
    {
        return $this->circularReference;
    }

    /**
     * @param CircularReferenceTestObject $circularReference
     */
    public function setCircularReference(CircularReferenceTestObject $circularReference): void
    {
        $this->circularReference = $circularReference;
    }
}