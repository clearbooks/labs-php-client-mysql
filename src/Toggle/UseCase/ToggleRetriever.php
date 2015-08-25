<?php
namespace Clearbooks\Labs\Toggle\UseCase;

use Clearbooks\Labs\Db\Entity\Toggle;

interface ToggleRetriever
{
    /**
     * @param int $toggleId
     * @return Toggle|null
     */
    public function getToggleById( $toggleId );
}
