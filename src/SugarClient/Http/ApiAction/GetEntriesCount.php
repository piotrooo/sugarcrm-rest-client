<?php
namespace SugarClient\Http\ApiAction;
use Ouzo\Utilities\Json;
use SugarClient\Core\Session;

/**
 * Class GetEntriesCount
 * @package SugarClient\Http\ApiAction
 * @author Piotr Olaszewski <piotroo89 [%] gmail dot com>
 */
class GetEntriesCount implements RequestAction
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
            'deleted' => 0
        );
        return Json::encode($parameters);
    }

    public function getMethod()
    {
        return 'get_entries_count';
    }
}
