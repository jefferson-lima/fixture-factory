<?php

namespace Jefferson\Lima\Test\TestObject;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

class ManyToManyInversedBy
{
    /**
     * @var ArrayCollection
     * @ORM\ManyToMany(targetEntity="ManyToManyMappedBy", inversedBy="manyToManyInversedBy")
     */
    public $manyToManyMappedBy;
}
