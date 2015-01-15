<?php
namespace SugarClient\Helper;

use Ouzo\Utilities\Inflector;
use Ouzo\Utilities\Strings;

class ClassCreator
{
    public static function createModule($moduleName)
    {
        $moduleName = ucfirst(Inflector::singularize($moduleName));
        $moduleName = Strings::appendPrefix($moduleName, '\SugarClient\Module\\');
        return new $moduleName();
    }
}
