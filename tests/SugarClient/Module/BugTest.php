<?php
namespace Tests\SugarClient\Module;

use Ouzo\Tests\Assert;
use SugarClient\Module\Bug;
use Tests\TestCase\SessionSugarTestCase;

class BugTest extends SessionSugarTestCase
{
    /**
     * @test
     */
    public function shouldReturnAccountsForBug()
    {
        //when
        $bug = Bug::findById('b0d20087-ef60-36cf-8d79-5404b012b723');

        //then
        Assert::thatArray($bug->accounts)->hasSize(2)
            ->onProperty('name')->containsOnly("Airline Maintenance Co", "Air Safety Inc");
    }

    /**
     * @test
     */
    public function shouldReturnContactsForBug()
    {
        //given

        //when
        $bug = Bug::findById('b0d20087-ef60-36cf-8d79-5404b012b723');

        //then
        Assert::thatArray($bug->contacts)->hasSize(1)
            ->onProperty('name')->containsOnly("Dante Tibbs");
    }
}
