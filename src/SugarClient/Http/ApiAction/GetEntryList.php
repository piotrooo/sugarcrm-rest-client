<?php
namespace SugarClient\Http\ApiAction;

use Ouzo\Utilities\Json;
use SugarClient\Session;

class GetEntryList implements RequestAction
{
    private $moduleName;
    private $where;
    private $fields;

    public function __construct($moduleName, $where, $fields)
    {
        $this->moduleName = $moduleName;
        $this->where = $where;
        $this->fields = $fields;
    }

    public function getRestData()
    {
        $parameters = array(
            'session' => Session::$sessionId,
            'module_name' => $this->moduleName,
            'query' => $this->where,
            'order_by' => '',
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
