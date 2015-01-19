<?php
namespace Tests\SugarClient\Core;

use SugarClient\Core\Session;
use Tests\MockSugarServer\TestCase\SugarServerTestCase;

class SessionTest extends SugarServerTestCase
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
        Session::connect('http://localhost/SugarCE-Full-6.5.17/service/v4_1/rest.php', 'admin', '123qwe');

        //then
        $this->assertNotNull(Session::$sessionId);
    }
}
