<?php
namespace SugarClient\Core;

/**
 * Class AttributesPreparer
 * @package SugarClient\Core
 * @author Piotr Olaszewski <piotroo89 [%] gmail dot com>
 */
class AttributesPreparer
{
    public static function prepare(array $attributes = array())
    {
        $result = array();
        foreach ($attributes as $column => $value) {
            $result[] = array('name' => $column, 'value' => $value);
        }
        return $result;
    }
}
