<?php
namespace Clearbooks\Labs\Db\Entity;

abstract class CamelCaseMapperEntity
{
    const WORD_DELIMITER = "_";

    /**
     * @param array $data
     */
    public function __construct( array $data )
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
        $transientProperties = $this->getTransientProperties();

        $reflectionClass = new \ReflectionClass( $this );
        $properties = $reflectionClass->getProperties( \ReflectionProperty::IS_PUBLIC | \ReflectionProperty::IS_PROTECTED );

        foreach ( $properties as $property ) {
            $propertyName = $property->getName();
            if ( in_array( $propertyName, $transientProperties ) ) {
                continue;
            }

            $data[$this->convertToDbKey( $propertyName )] = $this->{$propertyName};
        }

        return $data;
    }

    /**
     * @return array
     */
    protected function getTransientProperties()
    {
        return [ ];
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
