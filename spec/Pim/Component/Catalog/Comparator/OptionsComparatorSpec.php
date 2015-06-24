<?php

namespace spec\Pim\Component\Catalog\Comparator;

use PhpSpec\ObjectBehavior;

class OptionsComparatorSpec extends ObjectBehavior
{
    function it_is_a_comparator()
    {
        $this->shouldBeAnInstanceOf('Pim\Component\Catalog\Comparator\ComparatorInterface');
    }

    function it_supports_multiselect_type()
    {
        $this->supports('pim_catalog_multiselect')->shouldBe(true);
        $this->supports('pim_reference_data_multiselect')->shouldBe(true);
        $this->supports('other')->shouldBe(false);
    }

    function it_get_changes_when_adding_options_data()
    {
        $changes   = ['value' => ['42', '43'], 'locale' => 'en_US', 'scope' => 'ecommerce'];
        $originals = [];

        $this->compare($changes, $originals)->shouldReturn([
            'locale' => 'en_US',
            'scope'  => 'ecommerce',
            'value' => ['42', '43'],
        ]);
    }

    function it_get_changes_when_changing_options_data()
    {
        $changes   = ['value' => ['42', '43', '45'], 'locale' => 'en_US', 'scope' => 'ecommerce'];
        $originals = ['value' => ['42', '44']];

        $this->compare($changes, $originals)->shouldReturn([
            'locale' => 'en_US',
            'scope'  => 'ecommerce',
            'value' => ['43', '45'],
        ]);
    }

    function it_returns_null_when_option_is_the_same()
    {
        $changes   = ['value' => ['42', '44'], 'locale' => 'en_US', 'scope' => 'ecommerce'];
        $originals = ['value' => ['42', '44'], 'locale' => 'en_US', 'scope' => 'ecommerce'];

        $this->compare($changes, $originals)->shouldReturn(null);
    }
}
