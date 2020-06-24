<?php

namespace Jefferson\Lima\Test\TestObject;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

class ManyToManyUnidirectional
{
    /**
     * @var ArrayCollection
     * @ORM\ManyToMany(targetEntity="TestObject")
     */
    public $manyToManyUnidirectional;
}
