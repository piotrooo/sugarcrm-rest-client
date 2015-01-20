<?php
namespace SugarClient\Core;

use SugarClient\Http\Request;
use SugarClient\Http\Requests;

/**
 * Class QueryUpdate
 * @package SugarClient\Core
 * @author Piotr Olaszewski <piotroo89 [%] gmail dot com>
 */
class QueryUpdate
{
    private $attributes;

    public function __construct($attributes = array())
    {
        $this->attributes = AttributesPreparer::prepare($attributes);
    }

    public function whereId($id)
    {
        $this->attributes[] = array('name' => 'id', 'value' => $id);
        return $this;
    }

    public function into($moduleName)
    {
        Request::call(Requests::setEntry($moduleName, $this->attributes));
    }
}
