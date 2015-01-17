<?php
namespace Tests\SugarClient\Core;

use PHPUnit_Framework_TestCase;
use SugarClient\Core\WhereClause;
use SugarClient\Core\WherePreparer;

class WherePreparerTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function shouldAppendMultipleWhereClauses()
    {
        //given
        $whereClauses = array(
            new WhereClause('accounts', array('name' => 'some name')),
            new WhereClause('accounts', array('website' => 'http://foo.bar'))
        );

        //when
        $where = WherePreparer::prepare($whereClauses)->get();

        //then
        $this->assertEquals("accounts.name = 'some name' AND accounts.website = 'http://foo.bar'", $where);
    }
}
