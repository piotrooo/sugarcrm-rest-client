<?php
namespace SugarClient;

use SugarClient\Finder\DynamicFinder;

abstract class Module
{
    public static function findById($id)
    {
    }

    public static function __callStatic($name, $arguments)
    {
        $dynamicFinder = DynamicFinder::match($name);
        if ($dynamicFinder) {

        }
    }
}