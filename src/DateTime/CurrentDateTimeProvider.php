<?php
namespace Clearbooks\Labs\DateTime;

use Clearbooks\Labs\DateTime\UseCase\DateTimeProvider;
use DateTime;

class CurrentDateTimeProvider implements DateTimeProvider
{
    public function getDateTime(): DateTime
    {
        return new DateTime();
    }
}
