<?php
namespace SugarClient\Module;

use SugarClient\Core\Module;
use SugarClient\Relation\Type\HasMany;

/**
 * Class Account
 * @package SugarClient\Module
 * @author Piotr Olaszewski <piotroo89 [%] gmail dot com>
 */
class Account extends Module
{
    public function __construct($attributes = array())
    {
        parent::__construct(array(
            'attributes' => $attributes,
            'hasMany' => array(
                'contacts' => HasMany::module('Contact'),
                'leads' => HasMany::module('Lead')
            )
        ));
    }
}
