<?php
namespace Tests\SugarClient\Core;

use BadMethodCallException;
use Ouzo\Tests\Assert;
use SugarClient\Module\Account;
use SugarClient\Module\Contact;
use Tests\TestCase\SessionSugarTestCase;

class ModuleTest extends SessionSugarTestCase
{
    /**
     * @test
     */
    public function shouldSearchAccountsByName()
    {
        //when
        $account = Account::findByName('Airline Maintenance Co')->fetch();

        //then
        $this->assertEquals('Airline Maintenance Co', $account->name);
    }

    /**
     * @test
     */
    public function shouldSearchUsingSimpleWhere()
    {
        //when
        $account = Account::where(array('name' => 'Airline Maintenance Co'))->fetch();

        //then
        $this->assertEquals('Airline Maintenance Co', $account->name);
    }

    /**
     * @test
     */
    public function shouldSearchUsingWhere()
    {
        //when
        $accounts = Account::where(array('name' => "LIKE 'Q%'"))->fetchAll();

        //then
        Assert::thatArray($accounts)->hasSize(2)
            ->onProperty('name')->containsExactly('Q.R.&E. Corp', 'Q3 ARVRO III PR');
    }

    /**
     * @test
     */
    public function shouldGetModuleUsingBelongsToRelation()
    {
        //given
        $contact = Contact::findByLastName('Tibbs')->fetch();

        //when
        $accountName = $contact->account->name;

        //then
        $this->assertEquals('Airline Maintenance Co', $accountName);
    }

    /**
     * @test
     */
    public function shouldGetModuleUsingHasManyRelation()
    {
        //given
        $account = Account::findByName('Airline Maintenance Co')->fetch();

        //when
        $contacts = $account->contacts;

        //then
        Assert::thatArray($contacts)->hasSize(4)
            ->onProperty('full_name')->containsOnly('Jade Horta', 'Joshua Lacourse', 'Dante Tibbs', 'Agnes Foutz');
    }

    /**
     * @test
     */
    public function shouldReturnNullWhenAttributeOrRelationNotFound()
    {
        //given
        $account = new Account();

        //when
        $var = $account->some_variable;

        //then
        $this->assertNull($var);
    }

    /**
     * @test
     */
    public function shouldThrowExceptionWhenTryToFindWrongMethod()
    {
        //when
        try {
            Account::wrongMethod();
        } catch (BadMethodCallException $e) {
            //then
            $this->assertEquals('Method [wrongMethod] not exists', $e->getMessage());
        }
    }

    /**
     * @test
     */
    public function shouldGetOnlySpecifiedFields()
    {
        //when
        $account = Account::findByName('Airline Maintenance Co')->select('name', 'phone_office')->fetch();

        //then
        $this->assertEquals('Airline Maintenance Co', $account->name);
        $this->assertEquals('(557) 632-9276', $account->phone_office);
    }

    /**
     * @test
     */
    public function shouldGetOnlySpecifiedFieldsWhenQueryIsBildFromWhere()
    {
        //when
        $account = Account::where(array('name' => "LIKE 'Airline%'"))->select('name', 'phone_office')->fetch();

        //then
        $this->assertEquals('Airline Maintenance Co', $account->name);
        $this->assertEquals('(557) 632-9276', $account->phone_office);
    }

    /**
     * @test
     */
    public function shouldReturnSugarCrmModuleName()
    {
        //given
        $account = new Account();

        //when
        $moduleName = $account->getModuleName();

        //then
        $this->assertEquals('Accounts', $moduleName);
    }

    /**
     * @test
     */
    public function shouldReturnSugarCrmModuleDbName()
    {
        //given
        $account = new Account();

        //when
        $moduleName = $account->getModuleDbName();

        //then
        $this->assertEquals('accounts', $moduleName);
    }

    /**
     * @test
     */
    public function shouldFetchJoinedRelation()
    {
        //given
        $contact = Contact::where(array('last_name' => 'Tibbs'))->join('account')->fetch();

        //when
        $name = $contact->account->name;

        //then
        $this->assertEquals('Airline Maintenance Co', $name);
    }

    /**
     * @test
     */
    public function shouldFetchJoinedRelationWithSpecificFields()
    {
        //given
        $contact = Contact::where(array('last_name' => 'Tibbs'))->join('account', array('id', 'name'))->fetch();

        //when
        $attributes = $contact->account->getAttributes();

        //then
        Assert::thatArray($attributes)->hasSize(2)
            ->containsKeyAndValue(array('id' => 'c64beab6-d6b8-a091-7ea4-5404b0908e80', 'name' => 'Airline Maintenance Co'));
    }

    /**
     * @test
     */
    public function shouldJoinRelationsWhenFetchAll()
    {
        //when
        $accounts = Account::where(array('name' => "LIKE 'Q%'"))->join('contacts', array('id', 'last_name'))->fetchAll();

        //then
        Assert::thatArray($accounts)->hasSize(2);
        Assert::thatArray($accounts[0]->contacts)->hasSize(4)
            ->onProperty('last_name')->containsExactly("Tokarz", "Pelt", "Dangelo", "Galusha");
        Assert::thatArray($accounts[1]->contacts)->hasSize(7)
            ->onProperty('last_name')->containsExactly("Mccaulley", "Raker", "Crespo", "Barros", "Marriott", "Ottley", "Hildebrandt");
    }

    /**
     * @test
     */
    public function shouldMultipleJoins()
    {
        //given
        $account = Account::findByName('Airline Maintenance Co')
            ->join('contacts')
            ->join('leads')
            ->fetch();

        //when
        $contacts = $account->contacts;
        $leads = $account->leads;

        //then
        $this->assertCount(4, $contacts);
        $this->assertCount(1, $leads);
    }

    /**
     * @test
     */
    public function shouldJoinRelationsThroughOtherRelation()
    {
        //when
        $contact = Contact::where(array('last_name' => 'Tibbs'))
            ->join('account->leads')
            ->fetch();

        //then
        $this->assertTrue(isset($contact->account->leads));
    }

    /**
     * @test
     */
    public function shouldReturnResultsOrderedByName()
    {
        $this->markTestSkipped("Order doesn't working");
        //when
        $account = Account::where(array('name' => "LIKE 'Air%'"))->order('accounts.name desc')->fetchAll();

        //then
        Assert::thatArray($account)->hasSize(2)
            ->onProperty('name')->containsExactly();
    }

    /**
     * @test
     */
    public function shouldSearchWhenPassStringInWhere()
    {
        //when
        $contact = Contact::where("contacts.last_name = 'Tibbs'")->fetch();

        //then
        $this->assertEquals('4d246443-a503-c984-11f4-5404b00baa09', $contact->id);
    }

    /**
     * @test
     */
    public function shouldReturnCountOfRecords()
    {
        //when
        $count = Account::count(array('name' => "LIKE 'Air%'"));

        //then
        $this->assertEquals(2, $count);
    }

    /**
     * @test
     */
    public function shouldSearchById()
    {
        //when
        $contact = Contact::findById('4d246443-a503-c984-11f4-5404b00baa09');

        //then
        $this->assertEquals('Tibbs', $contact->last_name);
    }

    /**
     * @test
     */
    public function shouldInsertAccount()
    {
        //given
        $account = new Account();
        $account->name = 'New Company';

        //when
        $id = $account->insert();

        //then
        $this->assertNotEmpty($id);
        $account->delete();
    }

    /**
     * @test
     */
    public function shouldDeleteRecord()
    {
        //given
        $account = new Account();
        $account->name = 'New Company';
        $id = $account->insert();

        //when
        Account::findById($id)->delete();

        //then
        $account = Account::findById($id);
        $this->assertNull($account);
    }
}
