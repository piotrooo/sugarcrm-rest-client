<?php
namespace Tests\MockSugarServer;

class Dispatcher
{
    public function handle($json)
    {
        print_r($json);
    }
}
