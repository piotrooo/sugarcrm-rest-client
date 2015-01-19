<?php
namespace Tests\MockSugarServer\Action;

abstract class BaseAction
{
    protected $response;
    protected $defaultElements;

    abstract public function process();

    protected function addDefaultElement(array $data)
    {
        $this->defaultElements[] = (object)$data;
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
