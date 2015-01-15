<?php
namespace SugarClient\Finder;

use SugarClient\Core\Module;

class FinderBuilder extends BaseQueryBuilder
{
    public function __construct(Module $module, $where)
    {
        $this->module = $module;
        $this->where = $this->prepareWhere($where);
    }

    private function prepareWhere($where)
    {
        if (is_array($where)) {
            $whereString = '';
            foreach ($where as $column => $value) {
                $whereString .= $this->module->getModuleDbName() . '.' . $column . " = '" . $value . "' AND ";
            }
            return rtrim($whereString, ' AND ');
        }
        return '';
    }
}
