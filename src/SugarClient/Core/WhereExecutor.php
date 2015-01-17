<?php
namespace SugarClient\Core;

use Ouzo\Utilities\Functions;
use Ouzo\Utilities\Joiner;

/**
 * Class WhereExecutor
 * @package SugarClient\Core
 * @author Piotr Olaszewski <piotroo89 [%] gmail dot com>
 */
class WhereExecutor
{
    /**
     * @var WhereClause[]
     */
    private $whereClauses = array();

    private function __construct($whereClauses)
    {
        $this->whereClauses = $whereClauses;
    }

    public function get()
    {
        return Joiner::on(' AND ')
            ->mapValues(Functions::extract()->getWhere())
            ->join($this->whereClauses);
    }

    public static function prepare(array $whereClauses = array())
    {
        return new self($whereClauses);
    }
}
