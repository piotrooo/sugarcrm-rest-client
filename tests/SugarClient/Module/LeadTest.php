<?php
namespace Tests\SugarClient\Module;

use SugarClient\Module\Lead;
use Tests\TestCase\SessionSugarTestCase;

class LeadTest extends SessionSugarTestCase
{
    /**
     * @test
     */
    public function shouldGetLeadRelatedWithAccount()
    {
        //given
        $lead = Lead::where(array('last_name' => 'Nowak'))->fetch();

        //when
        $name = $lead->account->name;

        //then
        $this->assertEquals('Airline Maintenance Co', $name);
    }
}
