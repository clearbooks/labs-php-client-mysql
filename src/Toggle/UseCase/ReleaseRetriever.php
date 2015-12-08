<?php
namespace Clearbooks\Labs\Toggle\UseCase;

use Clearbooks\Labs\Db\Entity\Release;

interface ReleaseRetriever
{
    /**
     * @param int $releaseId
     * @return Release|null
     */
    public function getReleaseById( $releaseId );
}
