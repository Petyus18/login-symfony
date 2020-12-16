<?php

namespace App\Doctrine\ORM\Id;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Id\AbstractIdGenerator;

use App\Entity\EmployeeEntity;
use App\Enum\EmployeeDateAwareEntityFieldEnumMap;
use App\Repository\EmployeeEntityRepository;

class EmployeeIDGenerator extends AbstractIdGenerator {

    /**
     * @inheritDoc
     */
    public function generate(EntityManager $em, $entity) {
        /** @var  EmployeeEntity $entity */
        $actualSequence = $em->createQueryBuilder()
            ->select(sprintf('%s.%s', EmployeeEntityRepository::EMPLOYEE_ALIAS, EmployeeDateAwareEntityFieldEnumMap::EMP_NO))
            ->from(EmployeeEntity::class, EmployeeEntityRepository::EMPLOYEE_ALIAS)
            ->orderBy(sprintf('%s.%s', EmployeeEntityRepository::EMPLOYEE_ALIAS, EmployeeDateAwareEntityFieldEnumMap::EMP_NO), 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();

        if (NULL === $actualSequence) {
            return 1000;
        }
        return ++$actualSequence[EmployeeDateAwareEntityFieldEnumMap::EMP_NO];
    }
}