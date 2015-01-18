<?php
namespace SugarClient\Module;

use SugarClient\Core\Module;
use SugarClient\Relation\Type\BelongsTo;

/**
 * Class Opportunity
 * @package SugarClient\Module
 * @author Piotr Olaszewski <piotroo89 [%] gmail dot com>
 */
class Opportunity extends Module
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
