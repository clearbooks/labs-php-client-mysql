<?php
namespace Clearbooks\Labs\Toggle\UseCase;

interface UserAutoSubscriptionChecker
{
    /**
     * @param string $userId
     * @return bool
     */
    public function isUserAutoSubscriber( $userId );
}
