<?php
namespace Tests\SugarClient\Helper;

use Ouzo\Tests\Assert;
use SugarClient\Helper\ModuleFields;
use Tests\TestCase\SessionSugarTestCase;

class ModuleFieldsTest extends SessionSugarTestCase
{
    /**
     * @test
     */
    public function shouldGetModuleFields()
    {
        //when
        $moduleFields = ModuleFields::forModule('Contacts')->all();

        //then
        Assert::thatArray($moduleFields)->hasSize(63);
    }
}
