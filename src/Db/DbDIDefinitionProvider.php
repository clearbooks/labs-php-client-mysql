<?php
namespace Clearbooks\Labs\Db;

use Clearbooks\Labs\DIDefinitionProvider;

class DbDIDefinitionProvider implements DIDefinitionProvider
{
    /**
     * @return string[]
     */
    public function getDefinitionPaths()
    {
        return [
            __DIR__ . "/../../config/db-config.php",
            __DIR__ . "/../../config/db-mappings.php"
        ];
    }
}
