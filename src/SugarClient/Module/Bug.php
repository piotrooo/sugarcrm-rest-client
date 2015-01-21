<?php
namespace SugarClient\Module;

use SugarClient\Core\Module;
use SugarClient\Relation\Type\HasMany;

/**
 * Class Bug
 * @package SugarClient\Module
 * @author Piotr Olaszewski <piotroo89 [%] gmail dot com>
 */
class Bug extends Module
{
    public function __construct($attributes = array())
    {
        parent::__construct(array(
            'attributes' => $attributes,
            'hasMany' => array(
                'accounts' => HasMany::module('Account'),
                'contacts' => HasMany::module('Contact'),
                'documents' => HasMany::module('Document')
            )
        ));
    }
}
