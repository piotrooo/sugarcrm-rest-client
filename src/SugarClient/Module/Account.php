<?php
namespace SugarClient\Module;

use SugarClient\Module;

class Account extends Module
{
    public function __construct($attributes = array())
    {
        parent::__construct(array(
            'attributes' => $attributes
        ));
    }
}
