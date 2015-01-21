<?php
namespace SugarClient\Module;

use Exception;
use SugarClient\Core\File;
use SugarClient\Core\Module;
use SugarClient\Http\Request;
use SugarClient\Http\Requests;
use SugarClient\Relation\Type\HasMany;

/**
 * Class Document
 * @package SugarClient\Module
 * @author Piotr Olaszewski <piotroo89 [%] gmail dot com>
 */
class Document extends Module
{
    public function __construct($attributes = array())
    {
        parent::__construct(array(
            'attributes' => $attributes,
            'hasMany' => array(
                'accounts' => HasMany::module('Account'),
                'bugs' => HasMany::module('Bug')
            )
        ));
    }

    public function uploadFile($content, $fileName)
    {
        $call = Request::call(Requests::setDocumentRevision($this->id, $content, $fileName));
        $this->reload();
        return $call->id;
    }

    /**
     * @return File
     * @throws Exception
     */
    public function getFile()
    {
        $call = Request::call(Requests::getDocumentRevision($this->document_revision_id));
        return File::create($call);
    }
}
