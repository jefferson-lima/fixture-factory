<?php

namespace Jefferson\Lima\Test;

class SimpleTypeTestObject
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

    public function __get($name)
    {
        return $this->$name;
    }
}
