<?php
namespace Clearbooks\Labs\Toggle;

use Clearbooks\Labs\Toggle\UseCase\ToggleRetriever;

class ToggleGateway implements \Clearbooks\Labs\Client\Toggle\Gateway\ToggleGateway
{
    /**
     * @var ToggleRetriever
     */
    private $toggleRetriever;

    /**
     * @param ToggleRetriever $toggleRetriever
     */
    public function __construct( ToggleRetriever $toggleRetriever )
    {
        $this->toggleRetriever = $toggleRetriever;
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
}
