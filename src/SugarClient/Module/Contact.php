<?php
namespace SugarClient\Module;

use SugarClient\Module;
use SugarClient\Relation\Type\BelongsTo;

class Contact extends Module
{
    public function __construct($attributes = array())
    {
        parent::__construct(array(
            'attributes' => $attributes,
            'belongsTo' => array(
                'account' => BelongsTo::module('Account')
            )
        ));
    }
}
