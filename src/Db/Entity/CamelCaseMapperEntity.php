<?php
namespace Clearbooks\Labs\Db\Entity;

use ReflectionClass;
use ReflectionProperty;

abstract class CamelCaseMapperEntity
{
    private const string WORD_DELIMITER = "_";

    public function __construct( array $data = [ ] )
    {
        foreach ( $data as $key => $value ) {
            $property = $this->convertToCamelCase( $key );

            if ( property_exists( $this, $property ) ) {
                $this->{$property} = $value;
            }
        }
    }

    public function toArray(): array
    {
        $data = [ ];
        $reflectionClass = new ReflectionClass( $this );
        $properties = $reflectionClass->getProperties( ReflectionProperty::IS_PUBLIC | ReflectionProperty::IS_PROTECTED );

        foreach ( $properties as $property ) {
            if ( !$this->isPropertyRequiredInOutputArray( $property ) ) {
                continue;
            }

            $propertyName = $property->getName();
            $propertyValue = $this->{$propertyName};
            $data[$this->convertToDbKey( $propertyName )] = $propertyValue;
        }

        return $data;
    }

    private function isPropertyRequiredInOutputArray( ReflectionProperty $property ): bool
    {
        $docComment = $property->getDocComment();
        $isNullable = preg_match( "/^[\t *]*@Nullable[\t ]*$/m", $docComment );
        $isTransient = preg_match( "/^[\t *]*@Transient[\t ]*$/m", $docComment );
        $propertyName = $property->getName();
        $propertyValue = $this->{$propertyName};

        return ( $isNullable || $propertyValue !== null ) && !$isTransient;
    }

    private function convertToCamelCase( string $word ): string
    {
        return lcfirst( preg_replace_callback(
                                '/' . self::WORD_DELIMITER . '([a-z0-9])/i',
                                function ( $matches ) {
                                    return strtoupper( $matches[1] );
                                },
                                $word
                        ) );
    }

    private function convertToDbKey( string $word ): string
    {
        return strtolower( preg_replace( '/(.)([A-Z0-9])/', '$1' . self::WORD_DELIMITER . '$2', $word ) );
    }
}
