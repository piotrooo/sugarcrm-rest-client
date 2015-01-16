<?php
namespace SugarClient\Helper;

use SugarClient\Core\Module;

/**
 * Class Converter
 * @package SugarClient\Helper
 * @author Piotr Olaszewski <piotroo89 [%] gmail dot com>
 */
class Converter
{
    public static function toModules($results, Module $module)
    {
        $modules = array();
        foreach ($results->entry_list as $row) {
            $modules[] = self::toModule($row, $module);
        }
        return $modules;
    }

    public static function toModule($row, Module $module)
    {
        $attributes = array();
        foreach ($row->name_value_list as $data) {
            $name = $data->name;
            $value = $data->value;
            $attributes[$name] = $value;
        }
        return $module->newInstance($attributes);
    }
}
