<?php

namespace Niji\AutoAttributeOptionsSetterBundle\Doctrine\ORM\Repository;

use Akeneo\Pim\Structure\Bundle\Doctrine\ORM\Repository\AttributeOptionRepository as BaseAttributeOptionRepository;

class AttributeOptionRepository extends BaseAttributeOptionRepository
{
    /**
     * Check if option exists.
     *
     * @param $code
     *    Attribute option code.
     *
     * @return bool
     *    TRUE if the option exists, FALSE otherwise.
     *
     * @throws \Doctrine\ORM\NoResultException
     *    In case of no results found.
     * @throws \Doctrine\ORM\NonUniqueResultException
     *    In case of non unique result found.
     */
    public function optionExists($code) {
        if (null === $code) {
            return FALSE;
        }

        list($attributeCode, $optionCode) = explode('.', $code);

        $count = $this->createQueryBuilder('o')
          ->select('count(o.id)')
          ->innerJoin('o.attribute', 'a')
          ->where('a.code=:attribute_code')
          ->andWhere('o.code=:option_code')
          ->setParameter('option_code', $optionCode)
          ->setParameter('attribute_code', $attributeCode)
          ->getQuery()
          ->getSingleScalarResult();

        return (isset($count) && intval($count) > 0);
    }
}