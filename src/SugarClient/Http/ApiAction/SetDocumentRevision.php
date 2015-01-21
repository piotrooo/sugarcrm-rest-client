<?php
namespace SugarClient\Http\ApiAction;

use Ouzo\Utilities\Json;
use SugarClient\Core\Session;

/**
 * Class SetDocumentRevision
 * @package SugarClient\Http\ApiAction
 * @author Piotr Olaszewski <piotroo89 [%] gmail dot com>
 */
class SetDocumentRevision implements RequestAction
{
    private $documentId;
    private $content;
    private $fileName;

    public function __construct($documentId, $content, $fileName)
    {
        $this->documentId = $documentId;
        $this->content = $content;
        $this->fileName = $fileName;
    }

    public function getRestData()
    {
        $parameters = array(
            "session" => Session::$sessionId,
            "note" => array(
                'id' => $this->documentId,
                'file' => base64_encode($this->content),
                'filename' => $this->fileName,
                'revision' => '1'
            )
        );
        return Json::encode($parameters);
    }

    public function getMethod()
    {
        return 'set_document_revision';
    }
}
