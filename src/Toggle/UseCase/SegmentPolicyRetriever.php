<?php
namespace Clearbooks\Labs\Toggle\UseCase;

interface SegmentPolicyRetriever
{
    public function getSegmentPolicyOfToggle( string $toggleName, string $segmentId ): ?bool;
}
