<?php

namespace Jefferson\Lima\Test\TestObject;

use Doctrine\ORM\Mapping\OneToOne;

class OneToOneB
{
    /**
     * @var OneToOneA
     * @OneToOne(targetEntity="OneToOneA", mappedBy="oneToOneBInversedBy")
     */
    public $oneToOneAMappedBy;
}
