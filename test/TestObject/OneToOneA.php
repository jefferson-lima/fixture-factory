<?php

namespace Jefferson\Lima\Test\TestObject;

use Doctrine\ORM\Mapping\OneToOne;

class OneToOneA
{
    /**
     * @var OneToOneB
     * @OneToOne(targetEntity="OneToOneB", inversedBy="oneToOneA")
     */
    private $oneToOneWithInversedBy;

    /**
     * @return mixed
     */
    public function getOneToOneWithInversedBy()
    {
        return $this->oneToOneWithInversedBy;
    }

    /**
     * @param mixed $oneToOneWithInversedBy
     */
    public function setOneToOneWithInversedBy($oneToOneWithInversedBy): void
    {
        $this->oneToOneWithInversedBy = $oneToOneWithInversedBy;
    }
}