<?php
namespace SugarClient;

class ParametersBuilder
{
    private $parameters = array();

    public function addEntry($key, $value)
    {
        $this->parameters[$key] = $value;
        return $this;
    }

    public function toArray()
    {
        return $this->parameters;
    }
}