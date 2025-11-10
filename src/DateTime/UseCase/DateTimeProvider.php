<?php
namespace Clearbooks\Labs\DateTime\UseCase;

use DateTime;

interface DateTimeProvider
{
    public function getDateTime(): DateTime;
}
