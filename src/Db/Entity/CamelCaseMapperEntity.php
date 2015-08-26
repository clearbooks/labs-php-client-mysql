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
            if ( !$this->isPropertyRequiredInOutputArray( $property ) ) {
                continue;
            }

            $propertyName = $property->getName();
            $propertyValue = $this->{$propertyName};
            $data[$this->convertToDbKey( $propertyName )] = $propertyValue;
        }

        return $data;
    }

    /**
     * @param ReflectionProperty $property
     * @return bool
     */
    private function isPropertyRequiredInOutputArray( ReflectionProperty $property )
    {
        $isNullable = $this->isPropertyNullable( $property );
        $isTransient = $this->isPropertyTransient( $property );
        $propertyValue = $this->{$propertyName};

        return ( $isNullable || $propertyValue !== null ) && !$isTransient;
    }

    /**
     * @param ReflectionProperty $property
     * @return bool
     */
    private function isPropertyNullable( ReflectionProperty $property )
    {
        return $property->getAnnotations()->getOne( "Nullable" ) !== false;
    }

    /**
     * @param ReflectionProperty $property
     * @return bool
     */
    private function isPropertyTransient( ReflectionProperty $property )
    {
        return $property->getAnnotations()->getOne( "Transient" ) !== false;
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
