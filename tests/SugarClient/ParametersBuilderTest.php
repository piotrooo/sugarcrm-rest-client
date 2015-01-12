<?php
use SugarClient\ParametersBuilder;

class ParametersBuilderTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function shouldCreateArrayOfParameters()
    {
        //given
        $parametersBuilder = new ParametersBuilder();

        //when
        $toArray = $parametersBuilder
            ->addEntry('session', '1234')
            ->addEntry('module_name', 'Accounts')
            ->addEntry('query', "name = 'john'")
            ->addEntry('offset', 0)
            ->addEntry('select_fields', array())
            ->addEntry('link_name_to_fields_array', array())
            ->addEntry('max_result', 2)
            ->addEntry('deleted', 0)
            ->addEntry('favorites', false)
            ->toArray();

        //then
        $expected = array(
            'session' => '1234',
            'module_name' => 'Accounts',
            'query' => "name = 'john'",
            'offset' => 0,
            'select_fields' => array(),
            'link_name_to_fields_array' => array(),
            'max_result' => 2,
            'deleted' => 0,
            'favorites' => false
        );
        $this->assertEquals($expected, $toArray);
    }
}
