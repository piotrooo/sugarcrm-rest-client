<?php
namespace Tests\SugarClient\Module;

use Ouzo\Tests\Assert;
use Ouzo\Utilities\Path;
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

    /**
     * @test
     */
    public function shouldAddFile()
    {
        //given
        $document = new Document(array(
            'document_name' => 'new document test',
            'revision' => '1'
        ));
        $document->insert();
        $content = file_get_contents(Path::join(__DIR__, '..', '..', 'Resources', 'soapui-settings.xml'));
        $fileName = 'soapui-settings.xml';

        //when
        $document->uploadFile($content, $fileName);

        //then
        $file = $document->getFile();
        $this->assertEquals($fileName, $file->getFileName());
    }
}
