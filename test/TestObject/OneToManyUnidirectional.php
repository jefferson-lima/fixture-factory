<?php

namespace Jefferson\Lima\Test\TestObject;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\OneToMany;

class OneToManyUnidirectional
{
    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="TestObject")
     */
    public $oneToManyUnidirectional;
}
