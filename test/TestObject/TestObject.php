<?php

namespace Jefferson\Lima\Test\TestObject;

class TestObject
{
    private $nonAnnotatedAttr;

    /** @var  */
    private $invalidVarTagAttr;

    /** @var string */
    private $stringAttr;

    /** @var integer */
    private $integerAttr;

    /** @var int */
    private $intAttr;

    /** @var bool */
    private $boolAttr;

    /** @var boolean */
    private $booleanAttr;

    /** @var float */
    private $floatAttr;

    /** @var double */
    private $doubletAttr;

    /** @var array */
    private $arrayAttr;

    /** @var string|int|null */
    private $multipleTypesAttr;

    /** @var NestedTestObject */
    private $objAttr;

    public function __get($name)
    {
        return $this->$name;
    }
}
