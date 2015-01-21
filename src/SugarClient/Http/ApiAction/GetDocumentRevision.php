<?php
namespace SugarClient\Http\ApiAction;

use Ouzo\Utilities\Json;
use SugarClient\Core\Session;

/**
 * Class GetDocumentRevision
 * @package SugarClient\Http\ApiAction
 * @author Piotr Olaszewski <piotroo89 [%] gmail dot com>
 */
class GetDocumentRevision implements RequestAction
{
    private $documentId;

    public function __construct($documentId)
    {
        $this->documentId = $documentId;
    }

    public function getRestData()
    {
        $parameters = array(
            "session" => Session::$sessionId,
            "i" => $this->documentId
        );
        return Json::encode($parameters);
    }

    public function getMethod()
    {
        return 'get_document_revision';
    }
}
