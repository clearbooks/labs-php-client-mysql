<?php
/**
 * Created by PhpStorm.
 * User: ryan
 * Date: 17/08/15
 * Time: 11:52
 */

namespace Clearbooks\Labs\Mysql\Connection;


interface QueryBuilderProvider
{
    /**
     * @return \Doctrine\DBAL\Query\QueryBuilder
     */
    public function getQueryBuilder();
}