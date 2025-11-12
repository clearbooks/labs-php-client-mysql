<?php
namespace Clearbooks\Labs\Toggle\Entity;

use Clearbooks\Labs\Client\Toggle\Entity\User;

class UserStub implements User
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
