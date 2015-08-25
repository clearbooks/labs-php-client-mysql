<?php
namespace Clearbooks\Labs\Db\Entity;

use Notoj\ReflectionClass;
use Notoj\ReflectionProperty;

abstract class CamelCaseMapperEntity
{
    const WORD_DELIMITER = "_";

    /**
     * @param array $data
     */
    public function __construct( array $data = [ ] )
    {
        foreach ( $data as $key => $value ) {
            $property = $this->convertToCamelCase( $key );

            if ( property_exists( $this, $property ) ) {
                $this->{$property} = $value;
            }
        }
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $data = [ ];
        $reflectionClass = new ReflectionClass( $this );

        /** @var ReflectionProperty[] $properties */
        $properties = $reflectionClass->getProperties( \ReflectionProperty::IS_PUBLIC | \ReflectionProperty::IS_PROTECTED );

        foreach ( $properties as $property ) {
            $propertyName = $property->getName();
            $isNullable = $property->getAnnotations()->getOne( "Nullable" ) !== false;
            $isTransient = $property->getAnnotations()->getOne( "Transient" ) !== false;
            $propertyValue = $this->{$propertyName};

            if ( ( !$isNullable && $propertyValue === null ) || $isTransient ) {
                continue;
            }

            $data[$this->convertToDbKey( $propertyName )] = $propertyValue;
        }

        return $data;
    }

    /**
     * @param string $word
     * @return string
     */
    private function convertToCamelCase( $word )
    {
        return lcfirst( preg_replace_callback(
                                '/' . self::WORD_DELIMITER . '([a-z0-9])/i',
                                function ( $matches ) {
                                    return strtoupper( $matches[1] );
                                },
                                $word
                        ) );
    }

    /**
     * @param string $word
     * @return string
     */
    private function convertToDbKey( $word )
    {
        return strtolower( preg_replace( '/(.)([A-Z0-9])/', '$1' . self::WORD_DELIMITER . '$2', $word ) );
    }
}
