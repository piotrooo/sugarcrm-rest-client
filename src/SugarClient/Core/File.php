<?php
namespace SugarClient\Core;

use SugarClient\Http\Requests;
use SugarClient\Http\Request;
use Exception;

/**
 * Class File
 * @package SugarClient\Core
 * @author Piotr Olaszewski <piotroo89 [%] gmail dot com>
 */
class File
{
    private $id;
    private $fileName;
    private $revision;
    private $base64Content;

    public function __construct($id, $fileName, $revision, $base64Content)
    {
        $this->id = $id;
        $this->fileName = $fileName;
        $this->revision = $revision;
        $this->base64Content = $base64Content;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getFileName()
    {
        return $this->fileName;
    }

    public function getRevision()
    {
        return $this->revision;
    }

    public function saveTo($path)
    {
        $content = base64_decode($this->base64Content);
        return file_put_contents($path, $content) !== false;
    }

    public static function create($result)
    {
        $info = $result->document_revision;
        return new self($info->id, $info->filename, $info->revision, $info->file);
    }

    public static function findById($id)
    {
        $call = Request::call(Requests::getDocumentRevision($id));
        if (isset($call->number)) {
            throw new Exception($call->description);
        }
        return self::create($call);
    }
}
