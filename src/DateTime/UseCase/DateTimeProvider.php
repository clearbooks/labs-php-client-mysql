<?php
namespace Clearbooks\Labs\DateTime\UseCase;

interface DateTimeProvider
{
    /**
     * @return \DateTime
     */
    public function getDateTime();
}
