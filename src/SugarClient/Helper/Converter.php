<?php
namespace SugarClient\Helper;

class Converter
{
    public static function toModules($results, $module)
    {
        $modules = array();
        foreach ($results->entry_list as $row) {
            $modules[] = self::toModule($row, $module);
        }
        return $modules;
    }

    public static function toModule($row, $module)
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
