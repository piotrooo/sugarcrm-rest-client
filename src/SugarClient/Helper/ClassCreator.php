<?php
namespace SugarClient\Helper;

use Ouzo\Utilities\Inflector;
use Ouzo\Utilities\Strings;

class ClassCreator
{
    public static function createModule($modelName)
    {
        $modelName = ucfirst(Inflector::singularize($modelName));
        $modelName = Strings::appendPrefix($modelName, '\SugarClient\Module\\');
        return new $modelName();
    }
}
