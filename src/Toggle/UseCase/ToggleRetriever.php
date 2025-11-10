<?php
namespace Clearbooks\Labs\Toggle\UseCase;

use Clearbooks\Labs\Db\Entity\Toggle;

interface ToggleRetriever
{
    public function getToggleById( int $toggleId ): ?Toggle;

    public function getToggleByName( string $toggleName ): ?Toggle;
}
