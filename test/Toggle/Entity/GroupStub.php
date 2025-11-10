<?php
namespace Clearbooks\Labs\Toggle\Entity;

use Clearbooks\Labs\Client\Toggle\Entity\Group;

class GroupStub implements Group
{
    private string $id;

    public function __construct( string $id )
    {
        $this->id = $id;
    }

    public function getId(): string
    {
        return $this->id;
    }
}
