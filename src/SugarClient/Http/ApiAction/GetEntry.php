<?php
namespace SugarClient\Http\ApiAction;

use Ouzo\Utilities\Json;
use SugarClient\Core\Session;

/**
 * Class GetEntry
 * @package SugarClient\Http\ApiAction
 * @author Piotr Olaszewski <piotroo89 [%] gmail dot com>
 */
class GetEntry implements RequestAction
{
    private $moduleName;
    private $id;
    private $fields;

    public function __construct($moduleName, $id, array $fields = array())
    {
        $this->moduleName = $moduleName;
        $this->id = $id;
        $this->fields = $fields;
    }

    public function getRestData()
    {
        $parameters = array(
            'session' => Session::$sessionId,
            'module_name' => $this->moduleName,
            'id' => $this->id,
            'select_fields' => $this->fields,
            'link_name_to_fields_array' => array(),
            'track_view' => true
        );
        return Json::encode($parameters);
    }

    public function getMethod()
    {
        return 'get_entry';
    }
}
