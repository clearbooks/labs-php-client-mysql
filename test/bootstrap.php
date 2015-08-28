<?php
use Clearbooks\Labs\Bootstrap;
use Clearbooks\Labs\Db\DbDIDefinitionProvider;

require_once __DIR__ . "/../vendor/autoload.php";
require_once __DIR__ . "/../src/Bootstrap.php";

Bootstrap::getInstance()->init( [ DbDIDefinitionProvider::class ] );
