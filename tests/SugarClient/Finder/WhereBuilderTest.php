<?php
use SugarClient\Finder\WhereBuilder;
use SugarClient\Module\Account;

class WhereBuilderTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function shouldBuildWhereFromSimpleArray()
    {
        //given
        $params = array('name' => 'some name');

        //when
        $whereBuilder = new WhereBuilder('Accounts', new Account(), $params);

        //then
        $this->assertEquals("accounts.name = 'some name'", $whereBuilder->whereAsString());
    }

    /**
     * @test
     */
    public function shouldBuildWhereForMultipleSimpleValues()
    {
        //given
        $params = array('name' => 'some name', 'phone_office' => '123456');

        //when
        $whereBuilder = new WhereBuilder('Accounts', new Account(), $params);

        //then
        $this->assertEquals("accounts.name = 'some name' AND accounts.phone_office = '123456'", $whereBuilder->whereAsString());
    }

    /**
     * @test
     */
    public function shouldBuildWhereForLikeKeyword()
    {
        //given
        $params = array('name' => "LIKE 'name%'");

        //when
        $whereBuilder = new WhereBuilder('Accounts', new Account(), $params);

        //then
        $this->assertEquals("accounts.name LIKE 'name%'", $whereBuilder->whereAsString());
    }

    /**
     * @test
     */
    public function shouldBuildWhereForInKeyword()
    {
        //given
        $params = array('id' => "in ('3432fdsf', '3423-dfs', '786sdv')");

        //when
        $whereBuilder = new WhereBuilder('Accounts', new Account(), $params);

        //then
        $this->assertEquals("accounts.id in ('3432fdsf', '3423-dfs', '786sdv')", $whereBuilder->whereAsString());
    }

    /**
     * @test
     */
    public function shouldPrepareWhereFromString()
    {
        //given
        $params = "accounts.name = 'some name' OR phone_office = '333222111'";

        //when
        $whereBuilder = new WhereBuilder('Accounts', new Account(), $params);

        //then
        $this->assertEquals($params, $whereBuilder->whereAsString());
    }
}