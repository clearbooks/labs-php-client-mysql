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
    public const string IDENTITY_TYPE_USER = "user";
    public const string IDENTITY_TYPE_GROUP = "group";
    public const string IDENTITY_TYPE_SEGMENT = "segment";

    private Connection $connection;
    private ToggleTable $toggleTable;
    private UserPolicyTable $userPolicyTable;
    private GroupPolicyTable $groupPolicyTable;
    private SegmentPolicyTable $segmentPolicyTable;

    public function __construct( Connection $connection, ToggleTable $toggleTable, UserPolicyTable $userPolicyTable,
                                 GroupPolicyTable $groupPolicyTable, SegmentPolicyTable $segmentPolicyTable )
    {
        $this->connection = $connection;
        $this->toggleTable = $toggleTable;
        $this->userPolicyTable = $userPolicyTable;
        $this->groupPolicyTable = $groupPolicyTable;
        $this->segmentPolicyTable = $segmentPolicyTable;
    }

    public function getToggleById( int $toggleId ): ?Toggle
    {
        return $this->getToggleByColumnValue( "id", $toggleId );
    }

    public function getToggleByName( string $toggleName ): ?Toggle
    {
        return $this->getToggleByColumnValue( "name", $toggleName );
    }

    private function getToggleByColumnValue( string $columnName, mixed $columnValue ): ?Toggle
    {
        $queryBuilder = $this->connection->createQueryBuilder();
        $queryBuilder->select( "*" )->from( (string)$this->toggleTable )->where( $columnName . " = ?" );
        $queryBuilder->setParameter( 0, $columnValue );

        $toggleData = $queryBuilder->execute()->fetch();
        return !empty( $toggleData ) ? new Toggle( $toggleData ) : null;
    }

    public function insertToggle( Toggle $toggle ): int
    {
        $affectedRows = $this->connection->insert( $this->toggleTable, $toggle->toArray() );
        return $affectedRows > 0 ? $this->connection->lastInsertId() : 0;
    }

    public function setUserPolicy( int $toggleId, string $userId, ?bool $policy ): void
    {
        $this->setTogglePolicy( $toggleId, $userId, $policy, self::IDENTITY_TYPE_USER );
    }

    public function setGroupPolicy( int $toggleId, string $groupId, ?bool $policy ): void
    {
        $this->setTogglePolicy( $toggleId, $groupId, $policy, self::IDENTITY_TYPE_GROUP );
    }

    public function setSegmentPolicy( int $toggleId, string $groupId, ?bool $policy ): void
    {
        $this->setTogglePolicy( $toggleId, $groupId, $policy, self::IDENTITY_TYPE_SEGMENT );
    }

    /**
     * @throws \Doctrine\DBAL\Exception\InvalidArgumentException
     */
    public function setTogglePolicy( int $toggleId, string $identityId, ?bool $policy, string $typeOfIdentity ): void
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
     * @throws \Doctrine\DBAL\Exception\InvalidArgumentException
     */
    private function removeTogglePolicy( string $table, string $identityField, string $identityId, int $toggleId ): void
    {
        $this->connection->delete( $table,
                                   [ $identityField => $identityId, "toggle_id" => $toggleId ] );
    }

    private function createOrModifyTogglePolicy( int $toggleId, string $identityId, bool $policy,
                                                 string $typeOfIdentity, string $table, string $identityField ): void
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

    public function getUserPolicyOfToggle( string $toggleName, string $userId ): ?bool
    {
        return $this->getPolicyOfToggleByName( $toggleName, $userId, self::IDENTITY_TYPE_USER );
    }

    public function getGroupPolicyOfToggle( string $toggleName, string $groupId ): ?bool
    {
        return $this->getPolicyOfToggleByName( $toggleName, $groupId, self::IDENTITY_TYPE_GROUP );
    }

    public function getSegmentPolicyOfToggle( string $toggleName, string $segmentId ): ?bool
    {
        return $this->getPolicyOfToggleByName( $toggleName, $segmentId, self::IDENTITY_TYPE_SEGMENT );
    }

    public function getPolicyOfToggleByName( string $toggleName, string $identityId, string $typeOfIdentity ): ?bool
    {
        $toggle = $this->getToggleByName( $toggleName );
        if ( $toggle == null ) {
            return null;
        }

        return $this->getPolicyOfExistingToggle( $toggle, $identityId, $typeOfIdentity );
    }

    public function getPolicyOfToggleById( int $toggleId, string $identityId, string $typeOfIdentity ): ?bool
    {
        $toggle = $this->getToggleById( $toggleId );
        if ( $toggle == null ) {
            return null;
        }

        return $this->getPolicyOfExistingToggle( $toggle, $identityId, $typeOfIdentity );
    }

    private function getPolicyOfExistingToggle( Toggle $toggle, $identityId, $typeOfIdentity ): ?bool
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

    private function getPolicyTableByTypeOfIdentity( string $typeOfIdentity ): string
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

    private function getIdentityFieldByTypeOfIdentity( string $typeOfIdentity ): string
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
