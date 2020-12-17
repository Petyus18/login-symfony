<?php

namespace App\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Query\Expr\Join;

use App\Enum\DepartmentEmployeeEntityFieldEnumMap;
use App\Enum\DepartmentEntityFieldEnumMap;
use App\Enum\EmployeeDateAwareEntityFieldEnumMap;
use App\Enum\EmployeeEntityFieldEnumMap;
use App\Enum\SalaryEntityFieldEnumMap;
use App\Enum\TitleEntityFieldEnumMap;

use App\DataObject\ListRequestData;

use App\Entity\DepartmentEmployeeEntity;
use App\Entity\DepartmentEntity;
use App\Entity\SalaryEntity;
use App\Entity\TitleEntity;

class EmployeeEntityRepository extends EntityRepository {

    public const EMPLOYEE_ALIAS = 'e';
    public const SALARY_ALIAS = 's';
    public const TITLE_ALIAS = 't';
    public const DEPARTMENT_ALIAS = 'de';
    public const EMPLOYEE_DEPARTMENT_ALIAS = 'e_de';
    public const PARAMETER_TO_DATE = 'to_date';

    public const FIELD_MAP = [
        'emp_no' => 'e.emp_no',
        'first_name' => 'e.first_name',
        'last_name' => 'e.last_name',
        'hire_date' => 'e.hire_date',
        'title' => 't.title',
        'salary' => 's.salary',
        'dept_name' => 'de.dept_name',
    ];

    /**
     * @param ListRequestData $listRequestData
     * @return array
     * @throws \Exception
     */
    public function findAllEmployeeBYListRequest(ListRequestData $listRequestData): array {
        $queryBuilder = $this->createQueryBuilder(self::EMPLOYEE_ALIAS);

        $queryBuilder
            ->select(
                self::buildFieldNameWithAlias(self::EMPLOYEE_ALIAS, EmployeeEntityFieldEnumMap::EMP_NO),
                self::buildFieldNameWithAlias(self::EMPLOYEE_ALIAS, EmployeeEntityFieldEnumMap::BIRTH_DATE),
                self::buildFieldNameWithAlias(self::EMPLOYEE_ALIAS, EmployeeEntityFieldEnumMap::FIRST_NAME),
                self::buildFieldNameWithAlias(self::EMPLOYEE_ALIAS, EmployeeEntityFieldEnumMap::LAST_NAME),
                self::buildFieldNameWithAlias(self::EMPLOYEE_ALIAS, EmployeeEntityFieldEnumMap::GENDER),
                self::buildFieldNameWithAlias(self::EMPLOYEE_ALIAS, EmployeeEntityFieldEnumMap::HIRE_DATE),
                self::buildFieldNameWithAlias(self::TITLE_ALIAS, TitleEntityFieldEnumMap::TITLE),
                self::buildFieldNameWithAlias(self::SALARY_ALIAS, SalaryEntityFieldEnumMap::SALARY),
                self::buildFieldNameWithAlias(self::DEPARTMENT_ALIAS, DepartmentEntityFieldEnumMap::DEPT_NAME)
            );

        $this->addTitleJoin($queryBuilder);
        $this->addSalaryJoin($queryBuilder);
        $this->addDepartmentJoin($queryBuilder);

        $queryBuilder->setMaxResults($listRequestData->getLength());
        $queryBuilder->setFirstResult($listRequestData->getStart());

        foreach ($listRequestData->getOrders() as $sort => $order) {
            $queryBuilder->orderBy(self::getOrderMap($sort), $order);
        }

        $this->addFieldSearch($queryBuilder, $listRequestData);

        $queryBuilder->setParameter(self::PARAMETER_TO_DATE, new \DateTime());

        return $queryBuilder->getQuery()->getArrayResult();
    }

    /**
     * @return int
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function countAllEmployee(): int {
        $queryBuilder = $this->createQueryBuilder(self::EMPLOYEE_ALIAS);
        $queryBuilder->select('count(e.emp_no)');

        return $queryBuilder->getQuery()->getSingleScalarResult();
    }

    /**
     * @param ListRequestData $listRequestData
     * @return int
     */
    public function countEmployeeBYListRequest(ListRequestData $listRequestData): int {
        $queryBuilder = $this->createQueryBuilder(self::EMPLOYEE_ALIAS);
        $queryBuilder->select('count(e.emp_no)');

        $this->addTitleJoin($queryBuilder);
        $this->addDepartmentJoin($queryBuilder);

        $this->addFieldSearch($queryBuilder, $listRequestData);

        $queryBuilder->setParameter(self::PARAMETER_TO_DATE, new \DateTime());

        return $queryBuilder->getQuery()->getSingleScalarResult();
    }

    /**
     * @param QueryBuilder $queryBuilder
     */
    protected function addTitleJoin(QueryBuilder $queryBuilder) {
        $queryBuilder->leftJoin(TitleEntity::class, self::TITLE_ALIAS, Join::WITH, $queryBuilder->expr()->andX(
            $queryBuilder->expr()->eq(
                self::buildFieldNameWithAlias(self::EMPLOYEE_ALIAS, EmployeeEntityFieldEnumMap::EMP_NO),
                self::buildFieldNameWithAlias(self::TITLE_ALIAS, TitleEntityFieldEnumMap::EMPLOYEE)
            ),
            $queryBuilder->expr()->gte(
                self::buildFieldNameWithAlias(self::TITLE_ALIAS, TitleEntityFieldEnumMap::TO_DATE),
                ':to_date'
            )
        ));
    }

    /**
     * @param QueryBuilder $queryBuilder
     */
    protected function addSalaryJoin(QueryBuilder $queryBuilder) {
        $queryBuilder->leftJoin(SalaryEntity::class, self::SALARY_ALIAS, Join::WITH, $queryBuilder->expr()->andX(
            $queryBuilder->expr()->eq(
                self::buildFieldNameWithAlias(self::EMPLOYEE_ALIAS, EmployeeEntityFieldEnumMap::EMP_NO),
                self::buildFieldNameWithAlias(self::SALARY_ALIAS, SalaryEntityFieldEnumMap::EMPLOYEE)
            ),
            $queryBuilder->expr()->gte(
                self::buildFieldNameWithAlias(self::SALARY_ALIAS, SalaryEntityFieldEnumMap::TO_DATE),
                ':to_date'
            )
        ));
    }

    /**
     * @param QueryBuilder $queryBuilder
     */
    protected function addDepartmentJoin(QueryBuilder $queryBuilder): void {
        $queryBuilder->leftJoin(DepartmentEmployeeEntity::class, self::EMPLOYEE_DEPARTMENT_ALIAS, Join::WITH, $queryBuilder->expr()->andX(
            $queryBuilder->expr()->eq(
                self::buildFieldNameWithAlias(self::EMPLOYEE_ALIAS, EmployeeEntityFieldEnumMap::EMP_NO),
                self::buildFieldNameWithAlias(self::EMPLOYEE_DEPARTMENT_ALIAS, EmployeeDateAwareEntityFieldEnumMap::EMPLOYEE)
            ),
            $queryBuilder->expr()->gte(
                self::buildFieldNameWithAlias(self::EMPLOYEE_DEPARTMENT_ALIAS, DepartmentEmployeeEntityFieldEnumMap::TO_DATE),
                ':to_date'
            )
        ))->leftJoin(DepartmentEntity::class, self::DEPARTMENT_ALIAS, Join::WITH,
            $queryBuilder->expr()->eq(
                self::buildFieldNameWithAlias(self::EMPLOYEE_DEPARTMENT_ALIAS, DepartmentEmployeeEntityFieldEnumMap::DEPARTMENT),
                self::buildFieldNameWithAlias(self::DEPARTMENT_ALIAS, DepartmentEntityFieldEnumMap::DEPT_NO)
            )
        );
    }

    /**
     * @param QueryBuilder $queryBuilder
     * @param ListRequestData $listRequestData
     */
    protected function addFieldSearch(QueryBuilder $queryBuilder, ListRequestData $listRequestData): void {
        if (!$listRequestData->hasFieldSearch()) {
            return;
        }
        $andX = $queryBuilder->expr()->andX();
        foreach ($listRequestData->getFiledSearch() as $field => $value) {
            $andX->add(
                $queryBuilder->expr()->eq(self::getOrderMap($field), sprintf(':%s', $field))
            );
            $queryBuilder->setParameter($field, $value);
        }
        $queryBuilder->andWhere($andX);
    }

    /**
     * @param string $alias
     * @param string $fieldName
     * @return string
     */
    protected static function buildFieldNameWithAlias(string $alias, string $fieldName): string {
        return sprintf('%s.%s', $alias, $fieldName);
    }

    /**
     * @param string $string
     * @return string
     */
    protected static function getOrderMap(string $string): string {
        return self::FIELD_MAP[$string];
    }
}