<?php
namespace Clearbooks\Labs\Toggle\Entity;

use Clearbooks\Labs\Client\Toggle\Entity\Segment;

class SegmentStub implements Segment
{
    private string $segmentId;

    public function __construct( string $segmentId )
    {
        $this->segmentId = $segmentId;
    }

    public function getId(): string
    {
        return $this->segmentId;
    }

    public function getPriority(): int
    {
        return 0;
    }

    public function isLocked(): bool
    {
        return false;
    }
}
