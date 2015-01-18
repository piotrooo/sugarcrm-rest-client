<?php
namespace SugarClient\Module;

use SugarClient\Core\Module;
use SugarClient\Relation\Type\BelongsTo;
use SugarClient\Relation\Type\HasMany;

/**
 * Class Contact
 * @package SugarClient\Module
 * @author Piotr Olaszewski <piotroo89 [%] gmail dot com>
 */
class Contact extends Module
{
    public function __construct($attributes = array())
    {
        parent::__construct(array(
            'attributes' => $attributes,
            'belongsTo' => array(
                'account' => BelongsTo::module('Account')
            ),
            'hasMany' => array(
                'bugs' => HasMany::module('Bug')
            )
        ));
    }
}
