<?php

namespace Jefferson\Lima\Test\TestObject;

use Doctrine\ORM\Mapping\OneToOne;

class OneToOneC
{
    /**
     * @var OneToOneA
     * @OneToOne(targetEntity="OneToOneA", inversedBy="oneToOneMappedBy")
     */
    public $oneToOneAInversedBy;
}