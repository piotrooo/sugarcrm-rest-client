<?php
namespace SugarClient\Core;

use Ouzo\Utilities\Functions;
use Ouzo\Utilities\Joiner;

/**
 * Class WherePreparer
 * @package SugarClient\Core
 * @author Piotr Olaszewski <piotroo89 [%] gmail dot com>
 */
class WherePreparer
{
    private $where;

    private function __construct($where)
    {
        $this->where = $where;
    }

    public function get()
    {
        return $this->where;
    }

    public static function prepare(array $whereClauses = array())
    {
        $where = Joiner::on(' AND ')
            ->mapValues(Functions::extract()->getWhere())
            ->join($whereClauses);
        return new self($where);
    }
}
