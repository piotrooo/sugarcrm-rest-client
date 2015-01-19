<?php
namespace Tests\MockSugarServer;

use PHPUnit_Framework_TestCase;
use SugarClient\Http\Request;

class SugarServerTestCase extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        parent::setUp();
        Request::$requestHandler = new Dispatcher();
    }
}
