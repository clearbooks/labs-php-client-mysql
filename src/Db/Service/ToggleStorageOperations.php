<?php
namespace Clearbooks\Labs\Db\Service;

use Clearbooks\Labs\Toggle\UseCase\GroupPolicyRetriever;
use Clearbooks\Labs\Toggle\UseCase\SegmentPolicyRetriever;
use Clearbooks\Labs\Toggle\UseCase\ToggleRetriever;
use Clearbooks\Labs\Toggle\UseCase\UserPolicyRetriever;

interface ToggleStorageOperations extends ToggleRetriever, UserPolicyRetriever, GroupPolicyRetriever, SegmentPolicyRetriever
{

}
