<?php
use Ouzo\Tests\Assert;
use SugarClient\Module\Account;
use SugarClient\Module\Contact;
use SugarClient\Session;

class ModuleTest extends PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        parent::setUp();
        Session::connect('http://localhost/SugarCE-Full-6.5.17/service/v4_1/rest.php', 'admin', 'piotr123');
    }

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
    public function shouldGetRelation()
    {
        //given
        $account = Account::findByName('Airline Maintenance Co')->fetch();

        //when
        $contacts = $account->contacts;

        //then
        Assert::thatArray($contacts)->hasSize(4);
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
        } catch (BadMethodCallException $e) {//then
            $this->assertEquals('Method [wrongMethod] not exists', $e->getMessage());
        }
    }
}
