<?php
namespace SugarClient\Http\ApiAction;

use Ouzo\Utilities\Json;
use SugarClient\Core\Session;

/**
 * Class GetEntryList
 * @package SugarClient\Http\ApiAction
 * @author Piotr Olaszewski <piotroo89 [%] gmail dot com>
 */
class GetEntryList implements RequestAction
{
    private $moduleName;
    private $where;
    private $fields;
    private $orderBy;

    public function __construct($moduleName, $where, $fields, $orderBy)
    {
        $this->moduleName = $moduleName;
        $this->where = $where;
        $this->fields = $fields;
        $this->orderBy = $orderBy;
    }

    public function getRestData()
    {
        $parameters = array(
            'session' => Session::$sessionId,
            'module_name' => $this->moduleName,
            'query' => $this->where,
            'order_by' => $this->orderBy,
            'offset' => 0,
            'select_fields' => $this->fields,
            'link_name_to_fields_array' => '',
            'max_result' => 100,
            'deleted' => 0,
            'favorites' => false,
        );
        return Json::encode($parameters);
    }

    public function getMethod()
    {
        return 'get_entry_list';
    }
}
