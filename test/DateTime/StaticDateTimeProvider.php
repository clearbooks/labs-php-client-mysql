<?php
namespace Clearbooks\Labs\DateTime;

use Clearbooks\Labs\DateTime\UseCase\DateTimeProvider;

class StaticDateTimeProvider implements DateTimeProvider
{
    /**
     * @var \DateTime
     */
    private $dateTime;

    /**
     * @param \DateTime|null $dateTime
     */
    public function __construct( $dateTime = null )
    {
        if ( $dateTime instanceof \DateTime ) {
            $this->dateTime = $dateTime;
            return;
        }

        $this->dateTime = new \DateTime();
    }

    /**
     * @return \DateTime
     */
    public function getDateTime()
    {
        return $this->dateTime;
    }

    /**
     * @param \DateTime $dateTime
     */
    public function setDateTime( \DateTime $dateTime )
    {
        $this->dateTime = $dateTime;
    }
}
