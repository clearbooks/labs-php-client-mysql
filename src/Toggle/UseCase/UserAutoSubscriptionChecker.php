<?php
namespace Clearbooks\Labs\Toggle\UseCase;

interface UserAutoSubscriptionChecker
{
    public function isUserAutoSubscriber( string $userId ): bool;
}
