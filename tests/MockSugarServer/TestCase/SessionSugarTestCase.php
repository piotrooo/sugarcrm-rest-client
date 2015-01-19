<?php
namespace Tests\MockSugarServer\TestCase;

use SugarClient\Core\Session;

class SessionSugarTestCase extends SugarServerTestCase
{
    public function setUp()
    {
        parent::setUp();
        Session::connect('http://localhost/SugarCE-Full-6.5.17/service/v4_1/rest.php', 'admin', '123qwe');
    }
}
