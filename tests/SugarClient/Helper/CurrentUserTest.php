<?php
namespace Tests\SugarClient\Helper;

use SugarClient\Helper\CurrentUser;
use Tests\TestCase\SessionSugarTestCase;

class CurrentUserTest extends SessionSugarTestCase
{
    /**
     * @test
     */
    public function shouldReturnCurrentUserId()
    {
        //when
        $id = CurrentUser::getId();

        //then
        $this->assertEquals(1, $id);
    }
}
