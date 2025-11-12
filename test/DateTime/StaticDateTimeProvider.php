<?php
namespace Clearbooks\Labs\DateTime;

use Clearbooks\Labs\DateTime\UseCase\DateTimeProvider;
use DateTime;

class StaticDateTimeProvider implements DateTimeProvider
{
    private DateTime $dateTime;

    public function __construct( ?DateTime $dateTime = null )
    {
        if ( $dateTime instanceof DateTime ) {
            $this->dateTime = $dateTime;
            return;
        }

        $this->dateTime = new DateTime();
    }

    public function getDateTime(): DateTime
    {
        return $this->dateTime;
    }

    public function setDateTime( DateTime $dateTime ): void
    {
        $this->dateTime = $dateTime;
    }
}
