<?php
namespace Clearbooks\Labs\Toggle\Entity;

use Clearbooks\Labs\Client\Toggle\Entity\Group;

class GroupStub implements Group
{
    /**
     * @var string
     */
    private $id;

    /**
     * @param string $id
     */
    public function __construct( $id )
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }
}
