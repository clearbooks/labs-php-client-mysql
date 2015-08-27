<?php
namespace Clearbooks\Labs\Toggle;

class TogglePolicyResponse implements \Clearbooks\Labs\Client\Toggle\UseCase\Response\TogglePolicyResponse
{
    /**
     * @var bool|null
     */
    private $togglePolicyActive;

    /**
     * @param bool|null $togglePolicyActive
     */
    public function __construct( $togglePolicyActive )
    {
        $this->togglePolicyActive = $togglePolicyActive;
    }

    /**
     * @return bool
     */
    public function isEnabled()
    {
        return $this->togglePolicyActive === true;
    }

    /**
     * @return bool
     */
    public function isNotSet()
    {
        return $this->togglePolicyActive === null;
    }
}
