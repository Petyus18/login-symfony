<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(name="salaries")
 */
class SalaryEntity {

    /**
     * @var integer
     * @ORM\Column(type="integer", nullable=false)
     */
    protected $salary;

    /**
     * @var \DateTime
     * @ORM\Column(type="date", nullable=false)
     * @ORM\Id()
     */
    protected $from_date;

    /**
     * @var \DateTime
     * @ORM\Column(type="date", nullable=false)
     * @ORM\Id()
     */
    protected $to_date;

    /**
     * @var EmployeeEntity
     * @ORM\ManyToOne(targetEntity="EmployeeEntity", inversedBy="salaries")
     * @ORM\JoinColumn(name="emp_no", referencedColumnName="emp_no", onDelete="cascade")
     */
    protected $employee;

    /**
     * @return int
     */
    public function getSalary(): int {
        return $this->salary;
    }

    /**
     * @param int $salary
     */
    public function setSalary(int $salary): void {
        $this->salary = $salary;
    }

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
}