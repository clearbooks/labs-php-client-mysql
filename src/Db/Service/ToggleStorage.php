<?php
namespace Clearbooks\Labs\Db\Service;

use Clearbooks\Labs\Db\Table\Toggle as ToggleTable;
use Clearbooks\Labs\Db\Table\UserPolicy as UserPolicyTable;
use Clearbooks\Labs\Db\Table\GroupPolicy as GroupPolicyTable;
use Clearbooks\Labs\Db\Table\SegmentPolicy as SegmentPolicyTable;
use Clearbooks\Labs\Db\Entity\Toggle;
use Doctrine\DBAL\Connection;

class ToggleStorage implements ToggleStorageOperations
{
    const IDENTITY_TYPE_USER = "user";
    const IDENTITY_TYPE_GROUP = "group";
    const IDENTITY_TYPE_SEGMENT = "segment";

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
     * @var SegmentPolicyTable
     */
    private $segmentPolicyTable;

    /**
     * @param Connection $connection
     * @param ToggleTable $toggleTable
     * @param UserPolicyTable $userPolicyTable
     * @param GroupPolicyTable $groupPolicyTable
     * @param SegmentPolicyTable $segmentPolicyTable
     */
    public function __construct( Connection $connection, ToggleTable $toggleTable, UserPolicyTable $userPolicyTable,
                                 GroupPolicyTable $groupPolicyTable, SegmentPolicyTable $segmentPolicyTable )
    {
        $this->connection = $connection;
        $this->toggleTable = $toggleTable;
        $this->userPolicyTable = $userPolicyTable;
        $this->groupPolicyTable = $groupPolicyTable;
        $this->segmentPolicyTable = $segmentPolicyTable;
    }

    /**
     * @param int $toggleId
     * @return Toggle|null
     */
    public function getToggleById( $toggleId )
    {
        return $this->getToggleByColumnValue( "id", $toggleId );
    }

    /**
     * @param string $toggleName
     * @return Toggle|null
     */
    public function getToggleByName( $toggleName )
    {
        return $this->getToggleByColumnValue( "name", $toggleName );
    }

    /**
     * @param string $columnName
     * @param mixed  $columnValue
     * @return Toggle|null
     */
    private function getToggleByColumnValue( $columnName, $columnValue )
    {
        $queryBuilder = $this->connection->createQueryBuilder();
        $queryBuilder->select( "*" )->from( (string)$this->toggleTable )->where( $columnName . " = ?" );
        $queryBuilder->setParameter( 0, $columnValue );

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
        $this->setTogglePolicy( $toggleId, $userId, $policy, self::IDENTITY_TYPE_USER );
    }

    /**
     * @param int       $toggleId
     * @param string    $groupId
     * @param bool|null $policy
     */
    public function setGroupPolicy( $toggleId, $groupId, $policy )
    {
        $this->setTogglePolicy( $toggleId, $groupId, $policy, self::IDENTITY_TYPE_GROUP );
    }

    /**
     * @param int       $toggleId
     * @param string    $groupId
     * @param bool|null $policy
     */
    public function setSegmentPolicy( $toggleId, $groupId, $policy )
    {
        $this->setTogglePolicy( $toggleId, $groupId, $policy, self::IDENTITY_TYPE_SEGMENT );
    }

    /**
     * @param int       $toggleId
     * @param string    $identityId
     * @param bool|null $policy
     * @param string    $typeOfIdentity
     * @throws \Doctrine\DBAL\Exception\InvalidArgumentException
     */
    public function setTogglePolicy( $toggleId, $identityId, $policy, $typeOfIdentity )
    {
        $table = $this->getPolicyTableByTypeOfIdentity( $typeOfIdentity );
        $identityField = $this->getIdentityFieldByTypeOfIdentity( $typeOfIdentity );

        if ( $policy === null ) {
            $this->removeTogglePolicy( $table, $identityField, $identityId, $toggleId );
            return;
        }

        $this->createOrModifyTogglePolicy( $toggleId, $identityId, $policy, $typeOfIdentity, $table, $identityField );
    }

    /**
     * @param string $table
     * @param string $identityField
     * @param string $identityId
     * @param int    $toggleId
     * @throws \Doctrine\DBAL\Exception\InvalidArgumentException
     */
    private function removeTogglePolicy( $table, $identityField, $identityId, $toggleId )
    {
        $this->connection->delete( $table,
                                   [ $identityField => $identityId, "toggle_id" => $toggleId ] );
    }

    /**
     * @param int    $toggleId
     * @param string $identityId
     * @param bool   $policy
     * @param string $typeOfIdentity
     * @param string $table
     * @param string $identityField
     */
    private function createOrModifyTogglePolicy( $toggleId, $identityId, $policy, $typeOfIdentity, $table,
                                                 $identityField )
    {
        $currentPolicy = $this->getPolicyOfToggleById( $toggleId, $identityId, $typeOfIdentity );

        if ( $currentPolicy === null ) {
            $this->connection->insert( $table,
                                       [ $identityField => $identityId, "toggle_id" => $toggleId,
                                         "active"       => $policy ? 1 : 0 ] );
        }

        $this->connection->update( $table,
                                   [ "active" => $policy ? 1 : 0 ],
                                   [ $identityField => $identityId, "toggle_id" => $toggleId ] );
    }

    /**
     * @param string  $toggleName
     * @param string $userId
     * @return bool|null
     */
    public function getUserPolicyOfToggle( $toggleName, $userId )
    {
        return $this->getPolicyOfToggleByName( $toggleName, $userId, self::IDENTITY_TYPE_USER );
    }

    /**
     * @param string $toggleName
     * @param string $groupId
     * @return bool|null
     */
    public function getGroupPolicyOfToggle( $toggleName, $groupId )
    {
        return $this->getPolicyOfToggleByName( $toggleName, $groupId, self::IDENTITY_TYPE_GROUP );
    }

    /**
     * @param string $toggleName
     * @param string $segmentId
     * @return bool|null
     */
    public function getSegmentPolicyOfToggle( $toggleName, $segmentId )
    {
        return $this->getPolicyOfToggleByName( $toggleName, $segmentId, self::IDENTITY_TYPE_SEGMENT );
    }

    /**
     * @param string $toggleName
     * @param string $identityId
     * @param string $typeOfIdentity
     * @return bool|null
     */
    public function getPolicyOfToggleByName( $toggleName, $identityId, $typeOfIdentity )
    {
        $toggle = $this->getToggleByName( $toggleName );
        if ( $toggle == null ) {
            return null;
        }

        return $this->getPolicyOfExistingToggle( $toggle, $identityId, $typeOfIdentity );
    }

    /**
     * @param int $toggleId
     * @param string $identityId
     * @param string $typeOfIdentity
     * @return bool|null
     */
    public function getPolicyOfToggleById( $toggleId, $identityId, $typeOfIdentity )
    {
        $toggle = $this->getToggleById( $toggleId );
        if ( $toggle == null ) {
            return null;
        }

        return $this->getPolicyOfExistingToggle( $toggle, $identityId, $typeOfIdentity );
    }

    private function getPolicyOfExistingToggle( Toggle $toggle, $identityId, $typeOfIdentity )
    {
        $table = $this->getPolicyTableByTypeOfIdentity( $typeOfIdentity );
        $identityField = $this->getIdentityFieldByTypeOfIdentity( $typeOfIdentity );

        $queryBuilder = $this->connection->createQueryBuilder();
        $queryBuilder->select( "active" )->from( $table )
                     ->where( "{$identityField} = ? AND toggle_id = ?" );
        $queryBuilder->setParameter( 0, $identityId );
        $queryBuilder->setParameter( 1, $toggle->getId() );

        $active = $queryBuilder->executeQuery()->fetchOne();
        if ( $active === false ) {
            return null;
        }

        return (int)$active !== 0;
    }

    /**
     * @param string $typeOfIdentity
     * @return string
     */
    private function getPolicyTableByTypeOfIdentity( $typeOfIdentity )
    {
        switch ( $typeOfIdentity ) {
            case self::IDENTITY_TYPE_GROUP:
                return (string)$this->groupPolicyTable;

            case self::IDENTITY_TYPE_SEGMENT:
                return (string)$this->segmentPolicyTable;

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
            case self::IDENTITY_TYPE_GROUP:
                return "group_id";

            case self::IDENTITY_TYPE_SEGMENT:
                return "segment_id";

            default:
                return "user_id";
        }
    }
}
