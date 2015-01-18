<?php
namespace Tests\SugarClient\Core;

use SugarClient\Core\QueryInsert;

class QueryInsertTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function shouldReturnPreparedAttributes()
    {
        //given
        $queryInsert = new QueryInsert(array('first_name' => 'John', 'last_name' => 'Doe'));

        //when
        $attributes = $queryInsert->getAttributes();

        //then
        $this->assertEquals(array(
            array('name' => 'first_name', 'value' => 'John'),
            array('name' => 'last_name', 'value' => 'Doe')
        ), $attributes);
    }
}
