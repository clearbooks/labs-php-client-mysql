<?php
namespace Clearbooks\Labs\Toggle\UseCase;

interface SegmentPolicyRetriever
{
    /**
     * @param string $toggleName
     * @param string $segmentId
     * @return bool|null
     */
    public function getSegmentPolicyOfToggle( $toggleName, $segmentId );
}
