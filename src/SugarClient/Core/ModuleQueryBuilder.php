<?php
namespace SugarClient\Core;

use Exception;

/**
 * Class ModuleQueryBuilder
 * @package SugarClient\Core
 * @author Piotr Olaszewski <piotroo89 [%] gmail dot com>
 */
class ModuleQueryBuilder
{
    /**
     * @var Module
     */
    private $module;
    /**
     * @var Query
     */
    private $query;

    public function __construct(Module $module)
    {
        $this->module = $module;
        $this->query = new Query($module);
    }

    public function select()
    {
        $this->query->select(func_get_args());
        return $this;
    }

    public function where($params = array())
    {
        $this->query->where(new WhereClause($this->module->getModuleDbName(), $params));
        return $this;
    }

    public function join($relationName, array $relationFields = array())
    {
        $this->query->join(new JoinClause($relationName, $relationFields));
        return $this;
    }

    public function order($orderClause)
    {
        $this->query->order($orderClause);
        return $this;
    }

    public function count()
    {
        return $this->query->count();
    }

    /**
     * @return Module
     * @throws Exception
     */
    public function fetch()
    {
        return $this->query->fetch();
    }

    /**
     * @return Module[]
     * @throws Exception
     */
    public function fetchAll()
    {
        return $this->query->fetchAll();
    }
}
