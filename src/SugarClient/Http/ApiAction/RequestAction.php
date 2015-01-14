<?php
namespace SugarClient\Http\ApiAction;

interface RequestAction
{
    public function getRestData();

    public function getMethod();
}
