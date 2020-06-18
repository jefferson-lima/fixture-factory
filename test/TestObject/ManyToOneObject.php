<?php

namespace Jefferson\Lima\Test\TestObject;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ManyToOne;

class ManyToOneObject
{
    /**
     * @var ArrayCollection
     * @ORM\ManyToOne(targetEntity="TestObject")
     */
    public $manyToOneUnidirectional;
}
