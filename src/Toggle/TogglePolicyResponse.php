<?php
namespace Clearbooks\Labs\Toggle;

class TogglePolicyResponse implements \Clearbooks\Labs\Client\Toggle\UseCase\Response\TogglePolicyResponse
{
    private ?bool $togglePolicyActive;

    public function __construct( ?bool $togglePolicyActive )
    {
        $this->togglePolicyActive = $togglePolicyActive;
    }

    public function isEnabled(): bool
    {
        return $this->togglePolicyActive === true;
    }

    public function isNotSet(): bool
    {
        return $this->togglePolicyActive === null;
    }
}
