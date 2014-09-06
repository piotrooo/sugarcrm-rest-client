<?php
use SugarClient\Module\Account;
use SugarClient\Session;

class ModuleTest extends PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        parent::setUp();
        Session::connect('http://localhost/SugarCE-Full-6.5.17/service/v4_1/rest.php', 'admin', 'piotr123');
    }

    /**
     * @test
     */
    public function shouldSearchAccountsByName()
    {
        //when
        $account = Account::findByName('Airline Maintenance Co')->fetch();

        //then
        $this->assertEquals('Airline Maintenance Co', $account->name);
    }

    /**
     * @test
     */
    public function shouldSearchUsingWhere()
    {
        //given

        //when
        $account = Account::where(array('name' => "LIKE 'Q%'"))->fetchAll();

        //then
    }
}