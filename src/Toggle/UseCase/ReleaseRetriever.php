<?php
namespace Clearbooks\Labs\Toggle\UseCase;

use Clearbooks\Labs\Db\Entity\Release;

interface ReleaseRetriever
{
    public function getReleaseById( int $releaseId ): ?Release;
}
