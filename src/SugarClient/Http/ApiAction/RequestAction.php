<?php
namespace SugarClient\Http\ApiAction;

/**
 * Interface RequestAction
 * @package SugarClient\Http\ApiAction
 * @author Piotr Olaszewski <piotroo89 [%] gmail dot com>
 */
interface RequestAction
{
    public function getRestData();

    public function getMethod();
}
