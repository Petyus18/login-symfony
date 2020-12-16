<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(name="titles")
 */
class TitleEntity {

    /**
     * @var integer
     * @ORM\Id()
     * @ORM\Column(type="string", length=50, nullable=false)
     */
    protected $title;

    /**
     * @var \DateTime
     * @ORM\Id()
     * @ORM\Column(type="date", nullable=false)
     */
    protected $from_date;

    /**
     * @var \DateTime
     * @ORM\Column(type="date")
     */
    protected $to_date;

    /**
     * @var EmployeeEntity
     * @ORM\Id()
     * @ORM\ManyToOne(targetEntity="EmployeeEntity", inversedBy="titles")
     * @ORM\JoinColumn(name="emp_no", referencedColumnName="emp_no", onDelete="cascade")
     */
    protected $employee;

    /**
     * @return int
     */
    public function getTitle(): int {
        return $this->title;
    }

    /**
     * @param int $title
     */
    public function setTitle(int $title): void {
        $this->title = $title;
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