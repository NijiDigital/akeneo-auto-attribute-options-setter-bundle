<?php

namespace Niji\AutoAttributeOptionsSetterBundle\DependencyInjection\Compiler;

use Niji\AutoAttributeOptionsSetterBundle\Doctrine\ORM\Repository\AttributeOptionRepository;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class AttributeOptionCompilerPass implements CompilerPassInterface
{

    /**
     * You can modify the container here before it is dumped to PHP code.
     */
    public function process(ContainerBuilder $container)
    {
        $container->setParameter('pim_catalog.repository.attribute_option', AttributeOptionRepository::class);
        $attributeOptionRepo = $container->findDefinition('pim_catalog.repository.attribute_option');
        $attributeOptionRepo->setClass(AttributeOptionRepository::class);
    }
}