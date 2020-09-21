<?php
namespace Clearbooks\Labs\Db\Entity;

use PHPUnit\Framework\TestCase;

class CamelCaseMapperEntityTest extends TestCase
{
    /**
     * @test
     */
    public function WhenConstructingCamelCaseMapperEntity_CamelCasedAttributesWillBePopulated()
    {
        $data = [
                "invalid_property"    => "test1",
                "single"              => "test2",
                "multiple_words"      => "test3",
                "more_than_two_words" => "test4"
        ];

        $entity = new SampleEntityWithTransientProperty( $data );

        $this->assertNull( $entity->getInvalidProperty() );
        $this->assertFalse( property_exists( $entity, "invalidProperty" ) );
        $this->assertEquals( $entity->getSingle(), $data["single"] );
        $this->assertEquals( $entity->getMultipleWords(), $data["multiple_words"] );
        $this->assertEquals( $entity->getMoreThanTwoWords(), $data["more_than_two_words"] );
    }

    /**
     * @test
     */
    public function GivenEntityHasNoTransientProperties_WhenConvertingEntityBackToArray_ResultingArrayWillMatchTheOriginal()
    {
        $data = [
                "single"              => "test2",
                "multiple_words"      => "test3",
                "more_than_two_words" => "test4"
        ];

        $entity = new SampleEntityWithoutTransientProperty( $data );

        $this->assertEquals( $data, $entity->toArray() );
    }

    /**
     * @test
     */
    public function GivenEntityHasTransientProperties_WhenConvertingEntityBackToArray_ResultingArrayWillMatchTheOriginal()
    {
        $data = [
                "single"              => "test2",
                "multiple_words"      => "test3",
                "more_than_two_words" => "test4"
        ];

        $entity = new SampleEntityWithTransientProperty( $data );

        $this->assertEquals( $data, $entity->toArray() );
    }
}
