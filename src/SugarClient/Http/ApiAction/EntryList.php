<?php
namespace SugarClient\Http\ApiAction;

use Ouzo\Utilities\Json;
use SugarClient\Session;

class EntryList implements RequestAction
{
    private $moduleName;
    private $where;

    public function __construct($moduleName, $where)
    {
        $this->moduleName = $moduleName;
        $this->where = $where;
    }

    public function getRestData()
    {
        $parameters = array(
            'session' => Session::$sessionId,
            'module_name' => $this->moduleName,
            'query' => $this->where,
            'order_by' => '',
            'offset' => 0,
            'select_fields' => '',
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
