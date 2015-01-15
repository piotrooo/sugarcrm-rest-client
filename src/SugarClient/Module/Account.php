<?php
namespace SugarClient\Module;

use SugarClient\Core\Module;
use SugarClient\Relation\Type\HasMany;

class Account extends Module
{
    public function __construct($attributes = array())
    {
        parent::__construct(array(
            'attributes' => $attributes,
            'hasMany' => array(
                'contacts' => HasMany::module('Contact')
            )
        ));
    }
}
