<?php

namespace Niji\AutoAttributeOptionsSetterBundle\Component\Catalog\Updater\Setter;

use Akeneo\Tool\Component\StorageUtils\Repository\IdentifiableObjectRepositoryInterface;
use Akeneo\Pim\Enrichment\Component\Product\Builder\EntityWithValuesBuilderInterface;
use Akeneo\Pim\Structure\Component\Model\AttributeInterface;
use Akeneo\Pim\Enrichment\Component\Product\Model\EntityWithValuesInterface;
use Akeneo\Pim\Structure\Component\Repository\AttributeOptionRepositoryInterface;
use Akeneo\Pim\Enrichment\Component\Product\Updater\Setter\AttributeSetter as BaseMultiSelectAttributeSetter;

class UnrestrictedMultiSelectAttributeSetter extends BaseMultiSelectAttributeSetter
{
    /** @var AttributeOptionRepositoryInterface */
    protected $attrOptionRepository;

    /** @var UnrestrictedCreateOptionValue */
    protected $unrestrictedCreateOptionValue;

    /**
     * UnrestrictedMultiSelectAttributeSetter constructor.
     * @param EntityWithValuesBuilderInterface $entityWithValuesBuilder
     * @param $supportedTypes
     * @param AttributeOptionRepositoryInterface $identifiableObjectRepositoryInterface
     * @param \Niji\AutoAttributeOptionsSetterBundle\Component\Catalog\Updater\Setter\UnrestrictedCreateOptionValue $unrestrictedCreateOptionValue
     */
    public function __construct(
        EntityWithValuesBuilderInterface $entityWithValuesBuilder,
        $supportedTypes,
        AttributeOptionRepositoryInterface $identifiableObjectRepositoryInterface,
        UnrestrictedCreateOptionValue $unrestrictedCreateOptionValue
    )
    {
        $this->attrOptionRepository = $identifiableObjectRepositoryInterface;
        $this->unrestrictedCreateOptionValue = $unrestrictedCreateOptionValue;
        parent::__construct($entityWithValuesBuilder, $supportedTypes);
    }


    /**
     * @param EntityWithValuesInterface $entityWithValues
     * @param AttributeInterface $attribute
     * @param mixed $data
     * @param array $options
     */
    public function setAttributeData(
        EntityWithValuesInterface $entityWithValues,
        AttributeInterface $attribute,
        $data,
        array $options = []
    ) {
        if (null === $data) {
            $option = null;
        } else {
            $data = preg_replace('/[^a-zA-Z0-9\']/', '_', $data);
            $this->checkOption($attribute, $data);
        }

        parent::setAttributeData($entityWithValues, $attribute, $data, $options);
    }

    /**
     * @param AttributeInterface $attribute
     * @param $datas
     */
    protected function checkOption(AttributeInterface $attribute, $datas)
    {
        if (null === $datas) {
            return;
        }

        foreach ($datas as $data){
            $identifier = $attribute->getCode() . '.' . $data;
            $optionExists = $this->attrOptionRepository->optionExists($identifier);

            if(!$optionExists){
                $this->unrestrictedCreateOptionValue->createOptionValue($attribute->getCode(), $data);
            }
        }
    }
}