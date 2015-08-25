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
        $this->setTogglePolicy( $toggleId, $userId, $policy, "user" );
    }

    /**
     * @param int       $toggleId
     * @param string    $groupId
     * @param bool|null $policy
     */
    public function setGroupPolicy( $toggleId, $groupId, $policy )
    {
        $this->setTogglePolicy( $toggleId, $groupId, $policy, "group" );
    }

    /**
     * @param int $toggleId
     * @param string $identityId
     * @param bool|null $policy
     * @param string $typeOfIdentity
     * @throws \Doctrine\DBAL\Exception\InvalidArgumentException
     */
    public function setTogglePolicy( $toggleId, $identityId, $policy, $typeOfIdentity )
    {
        $table = $this->getPolicyTableByTypeOfIdentity( $typeOfIdentity );
        $identityField = $this->getIdentityFieldByTypeOfIdentity( $typeOfIdentity );

        if ( $policy === null ) {
            $this->connection->delete( $table,
                                       [ $identityField => $identityId, "toggle_id" => $toggleId ] );
            return;
        }

        $currentPolicy = $this->getPolicyOfToggle( $toggleId, $identityId, $typeOfIdentity );

        if ( $currentPolicy === null ) {
            $this->connection->insert( $table,
                                       [ $identityField => $identityId, "toggle_id" => $toggleId,
                                         "active"  => $policy ? 1 : 0 ] );
        }

        $this->connection->update( $table,
                                   [ "active" => $policy ? 1 : 0 ],
                                   [ $identityField => $identityId, "toggle_id" => $toggleId ] );
    }

    /**
     * @param int    $toggleId
     * @param string $userId
     * @return bool|null
     */
    public function getUserPolicyOfToggle( $toggleId, $userId )
    {
        return $this->getPolicyOfToggle( $toggleId, $userId, "user" );
    }

    /**
     * @param int    $toggleId
     * @param string $groupId
     * @return bool|null
     */
    public function getGroupPolicyOfToggle( $toggleId, $groupId )
    {
        return $this->getPolicyOfToggle( $toggleId, $groupId, "group" );
    }

    /**
     * @param int $toggleId
     * @param string $identityId
     * @param string $typeOfIdentity
     * @return bool|null
     */
    public function getPolicyOfToggle( $toggleId, $identityId, $typeOfIdentity )
    {
        $table = $this->getPolicyTableByTypeOfIdentity( $typeOfIdentity );
        $identityField = $this->getIdentityFieldByTypeOfIdentity( $typeOfIdentity );

        $queryBuilder = $this->connection->createQueryBuilder();
        $queryBuilder->select( "active" )->from( $table )
                     ->where( "{$identityField} = ? AND toggle_id = ?" );
        $queryBuilder->setParameter( 0, $identityId );
        $queryBuilder->setParameter( 1, $toggleId );

        $active = $queryBuilder->execute()->fetchColumn();
        if ( $active === false ) {
            return null;
        }

        return $active === "0" ? false : true;
    }

    /**
     * @param string $typeOfIdentity
     * @return string
     */
    private function getPolicyTableByTypeOfIdentity( $typeOfIdentity )
    {
        switch ( $typeOfIdentity ) {
            case "group":
                return (string)$this->groupPolicyTable;

            default:
                return (string)$this->userPolicyTable;
        }
    }

    /**
     * @param string $typeOfIdentity
     * @return string
     */
    private function getIdentityFieldByTypeOfIdentity( $typeOfIdentity )
    {
        switch ( $typeOfIdentity ) {
            case "group":
                return "group_id";

            default:
                return "user_id";
        }
    }
}
