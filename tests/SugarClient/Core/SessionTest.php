<?php
namespace Tests\SugarClient\Core;

use PHPUnit_Framework_TestCase;
use SugarClient\Core\Session;

class SessionTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @expectedException \SugarClient\Core\LoginException
     */
    public function shouldThrowLoginExceptionWhenPasswordIsWrong()
    {
        //when
        Session::connect('http://localhost/SugarCE-Full-6.5.17/service/v4_1/rest.php', 'admin', 'wrong password');
    }

    /**
     * @test
     */
    public function shouldSetSessionId()
    {
        //when
        Session::connect('http://localhost/SugarCE-Full-6.5.17/service/v4_1/rest.php', 'admin', 'piotr123');

        //then
        $this->assertNotNull(Session::$sessionId);
    }
}
