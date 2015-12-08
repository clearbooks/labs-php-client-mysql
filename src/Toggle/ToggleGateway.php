<?php
namespace Clearbooks\Labs\Toggle;

use Clearbooks\Labs\DateTime\UseCase\DateTimeProvider;
use Clearbooks\Labs\Db\Table\Toggle as ToggleTable;
use Clearbooks\Labs\Toggle\UseCase\ReleaseRetriever;
use Clearbooks\Labs\Toggle\UseCase\ToggleRetriever;

class ToggleGateway implements \Clearbooks\Labs\Client\Toggle\Gateway\ToggleGateway
{
    /**
     * @var ToggleRetriever
     */
    private $toggleRetriever;

    /**
     * @var ReleaseRetriever
     */
    private $releaseRetriever;

    /**
     * @var DateTimeProvider
     */
    private $dateTimeProvider;

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
    public function isToggleVisibleForUsers( $toggleName )
    {
        $toggle = $this->toggleRetriever->getToggleByName( $toggleName );
        return $toggle != null && $toggle->isVisible();
    }

    /**
     * @param string $toggleName
     * @return bool
     */
    public function isGroupToggle( $toggleName )
    {
        $toggle = $this->toggleRetriever->getToggleByName( $toggleName );
        return $toggle != null && $toggle->getType() === ToggleTable::TYPE_GROUP;
    }

    /**
     * @param string $toggleName
     * @return bool
     */
    public function isReleaseDateOfToggleReleaseTodayOrInThePast( $toggleName )
    {
        $toggle = $this->toggleRetriever->getToggleByName( $toggleName );
        if ( $toggle == null || empty( $toggle->getReleaseId() ) ) {
            return false;
        }

        $release = $this->releaseRetriever->getReleaseById( $toggle->getReleaseId() );
        return $release != null && $release->getReleaseDate() != null &&
               $release->getReleaseDate() <= $this->dateTimeProvider->getDateTime();
    }
}
