<?php

namespace Jefferson\Lima\Test\TestObject;

class NestedTestObject
{
    /** @var string */
    private $stringAttr;

    /** @var int */
    private $intAttr;

    /**
     * @return string
     */
    public function getStringAttr(): string
    {
        return $this->stringAttr;
    }

    /**
     * @param string $stringAttr
     */
    public function setStringAttr(string $stringAttr): void
    {
        $this->stringAttr = $stringAttr;
    }

    /**
     * @return int
     */
    public function getIntAttr(): int
    {
        return $this->intAttr;
    }

    /**
     * @param int $intAttr
     */
    public function setIntAttr(int $intAttr): void
    {
        $this->intAttr = $intAttr;
    }
}