<?php

namespace Niji\AutoAttributeOptionsSetterBundle\EventListener;

use Doctrine\Common\EventSubscriber;
use Doctrine\Common\Persistence\Mapping\ClassMetadata;
use Doctrine\ORM\Event\LoadClassMetadataEventArgs;

class ClassMetadataListener implements EventSubscriber
{
    /**
     * Run when Doctrine ORM metadata is loaded.
     *
     * @param LoadClassMetadataEventArgs $eventArgs
     */
    public function loadClassMetadata(LoadClassMetadataEventArgs $eventArgs)
    {
        /** @var ClassMetadata $classMetadata */
        $classMetadata = $eventArgs->getClassMetadata();

        $entityName = $classMetadata->getName();
        if ('Akeneo\Pim\Structure\Component\Model\AttributeOption' === $entityName) {
            $classMetadata->customRepositoryClassName = 'Niji\AutoAttributeOptionsSetterBundle\Doctrine\ORM\Repository\AttributeOptionRepository';
        }
    }

    /**
     * Returns an array of events this subscriber wants to listen to.
     *
     * @return array
     */
    public function getSubscribedEvents()
    {
        return array(
            Events::loadClassMetadata
        );
    }
}