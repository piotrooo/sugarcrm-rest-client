<?php
use SugarClient\Module\Account;
use SugarClient\Session;

class ModuleTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function shouldSearchAccountsByName()
    {
        //given
        Session::connect('http://localhost/SugarCE-Full-6.5.17/service/v4_1/rest.php', 'admin', 'piotr123');

        //when
        $account = Account::findByName('Airline Maintenance Co')->fetchAll();

        //then
        $this->assertEquals('Airline Maintenance Co', $account[0]->name);
    }
}