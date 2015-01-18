<?php
namespace Tests\SugarClient\Module;

use Ouzo\Tests\Assert;
use SugarClient\Module\Document;
use Tests\TestCase\SessionSugarTestCase;

class DocumentTest extends SessionSugarTestCase
{
    /**
     * @test
     */
    public function shouldGetDocumentWithAccounts()
    {
        //when
        $document = Document::where(array('document_name' => "LIKE 'Zrzut ekranu%'"))->fetch();

        //then
        Assert::thatArray($document->accounts)->hasSize(2)
            ->onProperty('name')->containsOnly("Air Safety Inc", "Airline Maintenance Co");
    }
}
