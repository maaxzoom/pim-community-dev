<?php

namespace spec\Pim\Bundle\TransformBundle\Builder;

use PhpSpec\ObjectBehavior;
use Pim\Component\Connector\ArrayConverter\Flat\Product\Extractor\ProductAttributeFieldExtractor;
use Pim\Component\Connector\ArrayConverter\Flat\Product\Resolver\AssociationFieldsResolver;

class FieldNameBuilderSpec extends ObjectBehavior
{
    function let(
        AssociationFieldsResolver $resolver,
        ProductAttributeFieldExtractor $extractor
    ) {
        $this->beConstructedWith($resolver, $extractor);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Pim\Bundle\TransformBundle\Builder\FieldNameBuilder');
    }

    function it_resolves_association_fields($resolver)
    {
        $resolver->resolveAssociationFields()->shouldBeCalled();
        $this->getAssociationFieldNames();
    }

    function it_resolves_attribute_info($extractor)
    {
        $extractor->extractAttributeFieldNameInfos('field')->shouldBeCalled();
        $this->extractAttributeFieldNameInfos('field');
    }
}
