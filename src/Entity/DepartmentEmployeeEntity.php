<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(name="dept_emp")
 */
class DepartmentEmployeeEntity {

    /**
     * @var \DateTime
     * @ORM\Column(type="date", nullable=false)
     */
    protected $from_date;

    /**
     * @var \DateTime
     * @ORM\Column(type="date", nullable=false)
     */
    protected $to_date;

    /**
     * @var EmployeeEntity
     * @ORM\ManyToOne(targetEntity="EmployeeEntity", inversedBy="departmentEmployees")
     * @ORM\JoinColumn(name="emp_no", referencedColumnName="emp_no", nullable=false, onDelete="cascade")
     * @ORM\Id()
     */
    protected $employee;

    /**
     * @var EmployeeEntity
     * @ORM\ManyToOne(targetEntity="DepartmentEntity")
     * @ORM\JoinColumn(name="dept_no", referencedColumnName="dept_no", nullable=false, onDelete="cascade")
     * @ORM\Id()
     */
    protected $department;

    /**
     * @return \DateTime
     */
    public function getFromDate(): \DateTime {
        return $this->from_date;
    }

    /**
     * @param \DateTime $from_date
     */
    public function setFromDate(\DateTime $from_date): void {
        $this->from_date = $from_date;
    }

    /**
     * @return \DateTime
     */
    public function getToDate(): \DateTime {
        return $this->to_date;
    }

    /**
     * @param \DateTime $to_date
     */
    public function setToDate(\DateTime $to_date): void {
        $this->to_date = $to_date;
    }

    /**
     * @return EmployeeEntity
     */
    public function getEmployee(): EmployeeEntity {
        return $this->employee;
    }

    /**
     * @param EmployeeEntity $employee
     */
    public function setEmployee(EmployeeEntity $employee): void {
        $this->employee = $employee;
    }

    /**
     * @return EmployeeEntity
     */
    public function getDepartment(): EmployeeEntity {
        return $this->department;
    }

    /**
     * @param EmployeeEntity $department
     */
    public function setDepartment(EmployeeEntity $department): void {
        $this->department = $department;
    }
}