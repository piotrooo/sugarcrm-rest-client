<?php
namespace Tests\TestCase;

use PHPUnit_Framework_TestCase;
use SugarClient\Core\Session;

class SessionSugarTestCase extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        parent::setUp();
        Session::connect('http://localhost/SugarCE-Full-6.5.17/service/v4_1/rest.php', 'admin', 'piotr123');
    }
}
