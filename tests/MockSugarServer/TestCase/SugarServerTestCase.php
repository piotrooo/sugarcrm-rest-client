<?php
namespace Tests\MockSugarServer\TestCase;

use PHPUnit_Framework_TestCase;
use SugarClient\Http\Request;
use SugarClient\Http\RequestHandler;
use Tests\MockSugarServer\Dispatcher;

class SugarServerTestCase extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        parent::setUp();
        Request::$requestHandler = new Dispatcher();
    }

    protected function tearDown()
    {
        Request::$requestHandler = new RequestHandler();
        parent::tearDown();
    }
}
