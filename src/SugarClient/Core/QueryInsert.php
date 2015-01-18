<?php
namespace SugarClient\Core;

use SugarClient\Http\Request;
use SugarClient\Http\Requests;

/**
 * Class QueryInsert
 * @package SugarClient\Core
 * @author Piotr Olaszewski <piotroo89 [%] gmail dot com>
 */
class QueryInsert
{
    private $attributes;

    public function __construct($attributes = array())
    {
        $this->attributes = $this->prepareAttributes($attributes);
    }

    private function prepareAttributes($attributes)
    {
        $result = array();
        foreach ($attributes as $column => $value) {
            $result[] = array('name' => $column, 'value' => $value);
        }
        return $result;
    }

    public function getAttributes()
    {
        return $this->attributes;
    }

    public function into($moduleName)
    {
        $call = Request::call(Requests::setEntry($moduleName, $this->attributes));
        return $call->id;
    }
}
