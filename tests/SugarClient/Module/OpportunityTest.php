<?php
namespace Tests\SugarClient\Module;

use SugarClient\Module\Opportunity;
use Tests\TestCase\SessionSugarTestCase;

class OpportunityTest extends SessionSugarTestCase
{
    /**
     * @test
     */
    public function shouldGetOpportunityWithAccount()
    {
        //when
        $opportunity = Opportunity::where(array('name' => "LIKE 'Some new%'"))->fetch();

        //then
        $this->assertEquals('Some new opportunity', $opportunity->name);
        $this->assertEquals('Airline Maintenance Co', $opportunity->account->name);
    }
}
