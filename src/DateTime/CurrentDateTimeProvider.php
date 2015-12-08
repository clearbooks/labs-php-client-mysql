<?php
namespace Clearbooks\Labs\DateTime;

use Clearbooks\Labs\DateTime\UseCase\DateTimeProvider;

class CurrentDateTimeProvider implements DateTimeProvider
{
    /**
     * @return \DateTime
     */
    public function getDateTime()
    {
        return new \DateTime();
    }
}
