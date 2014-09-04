<?php
use Ouzo\Tests\Assert;
use SugarClient\Finder\DynamicFinder;

class DynamicFinderTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function shouldParseOneField()
    {
        //given
        $method = 'findByName';

        //when
        $match = DynamicFinder::match($method);

        //then
        Assert::thatArray($match->getNames())->containsExactly('name');
    }

    /**
     * @test
     */
    public function shouldParseOneFieldWithMultipleNames()
    {
        //given
        $method = 'findByShippingAddressPostalcode';

        //when
        $match = DynamicFinder::match($method);

        //then
        Assert::thatArray($match->getNames())->containsExactly('shipping_address_postalcode');
    }

    /**
     * @test
     */
    public function shouldParseTwoFields()
    {
        //given
        $method = 'findByShippingAddressPostalcodeAndName';

        //when
        $match = DynamicFinder::match($method);

        //then
        Assert::thatArray($match->getNames())->containsExactly('shipping_address_postalcode', 'name');
    }
} 