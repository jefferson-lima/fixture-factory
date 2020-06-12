<?php

namespace Jefferson\Lima\Test\TestObject;

use Doctrine\ORM\Mapping\OneToOne;

class OneToOneA
{
    /**
     * @var OneToOneB
     * @OneToOne(targetEntity="OneToOneB", inversedBy="oneToOneAMappedBy")
     */
    public $oneToOneBInversedBy;

    /**
     * @var OneToOneC
     * @OneToOne(targetEntity="OneToOneC", mappedBy="oneToOneAInversedBy")
     */
    public $oneToOneCMappedBy;

    /**
     * @var TestObject
     * @OneToOne(targetEntity="TestObject")
     */
    public $oneToOneUnidirectional;
}
