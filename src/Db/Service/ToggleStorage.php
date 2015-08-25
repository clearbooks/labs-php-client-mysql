<?php
namespace Clearbooks\Labs\Db\Service;

use Clearbooks\Labs\Db\Table\Toggle as ToggleTable;
use Clearbooks\Labs\Db\Table\UserPolicy as UserPolicyTable;
use Clearbooks\Labs\Db\Table\GroupPolicy as GroupPolicyTable;
use Clearbooks\Labs\Db\Entity\Toggle;
use Clearbooks\Labs\Toggle\UseCase\GroupPolicyRetriever;
use Clearbooks\Labs\Toggle\UseCase\ToggleRetriever;
use Clearbooks\Labs\Toggle\UseCase\UserPolicyRetriever;
use Doctrine\DBAL\Connection;

class ToggleStorage implements ToggleRetriever, UserPolicyRetriever, GroupPolicyRetriever
{
    /**
     * @var Connection
     */
    private $connection;

    /**
     * @var ToggleTable
     */
    private $toggleTable;

    /**
     * @var UserPolicyTable
     */
    private $userPolicyTable;

    /**
     * @var GroupPolicyTable
     */
    private $groupPolicyTable;

    /**
     * @param Connection       $connection
     * @param ToggleTable      $toggleTable
     * @param UserPolicyTable  $userPolicyTable
     * @param GroupPolicyTable $groupPolicyTable
     */
    public function __construct( Connection $connection, ToggleTable $toggleTable, UserPolicyTable $userPolicyTable,
                                 GroupPolicyTable $groupPolicyTable )
    {
        $this->connection = $connection;
        $this->toggleTable = $toggleTable;
        $this->userPolicyTable = $userPolicyTable;
        $this->groupPolicyTable = $groupPolicyTable;
    }

    /**
     * @param int $toggleId
     * @return Toggle|null
     */
    public function getToggleById( $toggleId )
    {
        $queryBuilder = $this->connection->createQueryBuilder();
        $queryBuilder->select( "*" )->from( (string)$this->toggleTable )->where( "id = ?" );
        $queryBuilder->setParameter( 0, $toggleId );

        $toggleData = $queryBuilder->execute()->fetch();
        return !empty( $toggleData ) ? new Toggle( $toggleData ) : null;
    }

    /**
     * @param Toggle $toggle
     * @return int
     */
    public function insertToggle( Toggle $toggle )
    {
        $affectedRows = $this->connection->insert( $this->toggleTable, $toggle->toArray() );
        return $affectedRows > 0 ? $this->connection->lastInsertId() : 0;
    }

    /**
     * @param int       $toggleId
     * @param string    $userId
     * @param bool|null $policy
     */
    public function setUserPolicy( $toggleId, $userId, $policy )
    {
        if ( $policy === null ) {
            $this->connection->delete( (string)$this->userPolicyTable,
                                       [ "user_id" => $userId, "toggle_id" => $toggleId ] );
            return;
        }

        $currentPolicy = $this->getUserPolicyOfToggle( $toggleId, $userId );

        if ( $currentPolicy === null ) {
            $this->connection->insert( (string)$this->userPolicyTable,
                                       [ "user_id" => $userId, "toggle_id" => $toggleId,
                                         "active"  => $policy ? 1 : 0 ] );
            return;
        }

        $this->connection->update( (string)$this->userPolicyTable,
                                   [ "active" => $policy ? 1 : 0 ],
                                   [ "user_id" => $userId, "toggle_id" => $toggleId ] );
    }

    /**
     * @param int       $toggleId
     * @param string    $groupId
     * @param bool|null $policy
     */
    public function setGroupPolicy( $toggleId, $groupId, $policy )
    {
        if ( $policy === null ) {
            $this->connection->delete( (string)$this->groupPolicyTable,
                                       [ "group_id" => $groupId, "toggle_id" => $toggleId ] );
            return;
        }

        $currentPolicy = $this->getGroupPolicyOfToggle( $toggleId, $groupId );

        if ( $currentPolicy === null ) {
            $this->connection->insert( (string)$this->groupPolicyTable,
                                       [ "group_id" => $groupId, "toggle_id" => $toggleId,
                                         "active"  => $policy ? 1 : 0 ] );
        }

        $this->connection->update( (string)$this->groupPolicyTable,
                                   [ "active" => $policy ? 1 : 0 ],
                                   [ "group_id" => $groupId, "toggle_id" => $toggleId ] );
    }

    /**
     * @param int    $toggleId
     * @param string $userId
     * @return bool|null
     */
    public function getUserPolicyOfToggle( $toggleId, $userId )
    {
        $queryBuilder = $this->connection->createQueryBuilder();
        $queryBuilder->select( "active" )->from( (string)$this->userPolicyTable )
                     ->where( "user_id = ? AND toggle_id = ?" );
        $queryBuilder->setParameter( 0, $userId );
        $queryBuilder->setParameter( 1, $toggleId );

        $active = $queryBuilder->execute()->fetchColumn();
        if ( $active === false ) {
            return null;
        }

        return $active === "0" ? false : true;
    }

    /**
     * @param int    $toggleId
     * @param string $groupId
     * @return bool|null
     */
    public function getGroupPolicyOfToggle( $toggleId, $groupId )
    {
        $queryBuilder = $this->connection->createQueryBuilder();
        $queryBuilder->select( "active" )->from( (string)$this->groupPolicyTable )
                     ->where( "group_id = ? AND toggle_id = ?" );
        $queryBuilder->setParameter( 0, $groupId );
        $queryBuilder->setParameter( 1, $toggleId );

        $active = $queryBuilder->execute()->fetchColumn();
        if ( $active === false ) {
            return null;
        }

        return $active === "0" ? false : true;
    }
}
