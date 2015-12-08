<?php
namespace Clearbooks\Labs\Db\Service;

use Clearbooks\Labs\Db\Entity\Toggle;
use Clearbooks\Labs\Toggle\UseCase\ToggleRetriever;

class CachedToggleStorage implements ToggleRetriever
{
    /**
     * @var ToggleStorage
     */
    private $toggleStorage;

    /**
     * @var array
     */
    private $toggleIdToToggleMap = [ ];

    /**
     * @var array
     */
    private $toggleNameToToggleMap = [ ];

    /**
     * @param ToggleStorage $toggleStorage
     */
    public function __construct( ToggleStorage $toggleStorage )
    {
        $this->toggleStorage = $toggleStorage;
    }

    /**
     * @param int $toggleId
     * @return Toggle|null
     */
    public function getToggleById( $toggleId )
    {
        if ( !isset( $this->toggleIdToToggleMap[$toggleId] ) ) {
            $this->toggleIdToToggleMap[$toggleId] = $this->toggleStorage->getToggleById( $toggleId );
        }

        return $this->toggleIdToToggleMap[$toggleId];
    }

    /**
     * @param string $toggleName
     * @return Toggle|null
     */
    public function getToggleByName( $toggleName )
    {
        if ( !isset( $this->toggleNameToToggleMap[$toggleName] ) ) {
            $this->toggleNameToToggleMap[$toggleName] = $this->toggleStorage->getToggleByName( $toggleName );
        }

        return $this->toggleNameToToggleMap[$toggleName];
    }
}
