<?php
namespace Tests\SugarClient\Module;

use Ouzo\Tests\Assert;
use SugarClient\Module\Account;
use Tests\TestCase\SessionSugarTestCase;

class AccountTest extends SessionSugarTestCase
{
    /**
     * @test
     */
    public function shouldReturnAccountWithDocuments()
    {
        //given

        //when
        $account = Account::where(array('name' => "LIKE 'Airli%'"))->fetch();

        //then
        Assert::thatArray($account->documents)->hasSize(2)
            ->onProperty('document_name')->containsOnly("Zrzut ekranu z 2015-01-10 11:14:25.png", "dane1");
    }
}
