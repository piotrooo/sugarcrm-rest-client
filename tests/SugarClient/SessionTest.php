<?php
use SugarClient\Session;

class SessionTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @expectedException \SugarClient\LoginException
     */
    public function shouldThrowLoginExceptionWhenPasswordIsWrong()
    {
        //when
        Session::connect('http://localhost/SugarCE-Full-6.5.17/service/v4_1/rest.php', 'admin', 'wrong pasword');
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