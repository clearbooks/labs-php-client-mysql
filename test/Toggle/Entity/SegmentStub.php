<?php
namespace Clearbooks\Labs\Toggle\Entity;

use Clearbooks\Labs\Client\Toggle\Entity\Segment;

class SegmentStub implements Segment
{
    /**
     * @var string
     */
    private $segmentId;

    /**
     * @param string $segmentId
     */
    public function __construct( $segmentId )
    {
        $this->segmentId = $segmentId;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->segmentId;
    }

    /**
     * @return int
     */
    public function getPriority()
    {
        return 0;
    }

    /**
     * @return bool
     */
    public function isLocked()
    {
        return false;
    }
}
