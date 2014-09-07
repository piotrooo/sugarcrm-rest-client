<?php
namespace SugarClient\Finder;

class SearchHelper
{
    public static function convertResultToModules($results, $module)
    {
        $modules = array();
        foreach ($results->entry_list as $row) {
            $modules[] = self::convertRowToModule($row, $module);
        }
        return $modules;
    }

    public static function convertRowToModule($row, $module)
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