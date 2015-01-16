<?php
namespace Tests\SugarClient\Helper;

use Ouzo\Tests\Assert;
use PHPUnit_Framework_TestCase;
use SugarClient\Core\Session;
use SugarClient\Helper\ModuleFields;

class ModuleFieldsTest extends PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        parent::setUp();
        Session::connect('http://localhost/SugarCE-Full-6.5.17/service/v4_1/rest.php', 'admin', 'piotr123');
    }

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
