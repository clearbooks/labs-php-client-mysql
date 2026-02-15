<?php
namespace Clearbooks\Labs\Toggle;

use Clearbooks\Labs\DateTime\UseCase\DateTimeProvider;
use Clearbooks\Labs\Db\Entity\Release;
use Clearbooks\Labs\Db\Entity\Toggle;
use Clearbooks\Labs\Db\Table\Toggle as ToggleTable;
use Clearbooks\Labs\Toggle\UseCase\ReleaseRetriever;
use Clearbooks\Labs\Toggle\UseCase\ToggleRetriever;

class ToggleGateway implements \Clearbooks\Labs\Client\Toggle\Gateway\ToggleGateway
{
    private ToggleRetriever $toggleRetriever;
    private ReleaseRetriever $releaseRetriever;
    private DateTimeProvider $dateTimeProvider;

    /**
     * @param ToggleRetriever $toggleRetriever
     * @param ReleaseRetriever $releaseRetriever
     * @param DateTimeProvider $dateTimeProvider
     */
    public function __construct( ToggleRetriever $toggleRetriever, ReleaseRetriever $releaseRetriever,
                                 DateTimeProvider $dateTimeProvider )
    {
        $this->toggleRetriever = $toggleRetriever;
        $this->releaseRetriever = $releaseRetriever;
        $this->dateTimeProvider = $dateTimeProvider;
    }

    /**
     * @param string $toggleName
     * @return bool
     */
    public function isToggleVisibleForUsers( $toggleName ): bool
    {
        $toggle = $this->toggleRetriever->getToggleByName( $toggleName );
        return $toggle != null && $toggle->isVisible();
    }

    /**
     * @param string $toggleName
     * @return bool
     */
    public function isGroupToggle( $toggleName ): bool
    {
        $toggle = $this->toggleRetriever->getToggleByName( $toggleName );
        return $toggle != null && $toggle->getType() === ToggleTable::TYPE_GROUP;
    }

    /**
     * @param string $toggleName
     * @return bool
     */
    public function isReleaseDateOfToggleReleaseTodayOrInThePast( $toggleName ): bool
    {
        $toggle = $this->toggleRetriever->getToggleByName( $toggleName );
        if ( !$this->toggleHasRelease( $toggle ) ) {
            return false;
        }

        $release = $this->releaseRetriever->getReleaseById( $toggle->getReleaseId() );
        return $this->isReleaseDateSet( $release ) &&
               $release->getReleaseDate() <= $this->dateTimeProvider->getDateTime();
    }

    private function toggleHasRelease( ?Toggle $toggle ): bool
    {
        return $toggle instanceof Toggle && !empty( $toggle->getReleaseId() );
    }

    private function isReleaseDateSet( ?Release $release ): bool
    {
        return $release instanceof Release && $release->getReleaseDate() != null;
    }
}
