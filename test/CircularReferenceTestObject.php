<?php

namespace Jefferson\Lima\Test;

class CircularReferenceTestObject
{
    /** @var TestObject */
    private $nonCircularReference;

    /** @var CircularReferenceBackTestObject */
    private $backReference;

    /**
     * @return CircularReferenceBackTestObject
     */
    public function getBackReference(): CircularReferenceBackTestObject
    {
        return $this->backReference;
    }

    /**
     * @param CircularReferenceBackTestObject $backReference
     */
    public function setBackReference(CircularReferenceBackTestObject $backReference): void
    {
        $this->backReference = $backReference;
    }
}