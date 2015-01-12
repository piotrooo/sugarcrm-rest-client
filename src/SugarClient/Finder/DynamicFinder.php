<?php
namespace SugarClient\Finder;

use Ouzo\Utilities\Arrays;
use Ouzo\Utilities\Strings;

class DynamicFinder
{
    private $method;
    private $names;

    public function __construct($method)
    {
        $this->method = $method;
    }

    public function parse()
    {
        if (preg_match('/^findBy([a-zA-Z]\w*)$/', $this->method, $names)) {
            $names = explode('And', $names[1]);
            $this->names = Arrays::map($names, function ($name) {
                return Strings::camelCaseToUnderscore($name);
            });
        }
    }

    public function getNames()
    {
        return $this->names;
    }

    public static function match($method)
    {
        if (Strings::startsWith($method, 'findBy')) {
            $dynamicFinder = new self($method);
            $dynamicFinder->parse();
            return $dynamicFinder;
        }
        return null;
    }
}
