<?php
namespace Tests\MockSugarServer\Action;

use BadMethodCallException;
use Exception;

class BaseAction
{
    const SESSION_ID = '2qlkr4sa14p9s68jh4s92beg17';

    protected $post;
    protected $response;
    protected $defaultElements;

    public function __construct($post)
    {
        $this->post = $post;
        $this->addDefaultElement(array(
            'id' => self::SESSION_ID,
            'user_name' => 'admin',
            'password' => md5('123qwe')
        ));
    }

    public function process()
    {
        throw new BadMethodCallException("Method should be override by child classes");
    }

    protected function addDefaultElement(array $data)
    {
        $this->defaultElements[] = (object)$data;
    }

    protected function checkSession($sessionId)
    {
        if ($sessionId != self::SESSION_ID) {
            throw new Exception("Invalid session");
        }
    }

    protected function getElements()
    {
        return $this->defaultElements;
    }

    public function response()
    {
        return $this->response;
    }
}
