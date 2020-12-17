<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EmployeeEntityRepository")
 * @ORM\Table(name="employees")
 */
class EmployeeEntity {

    /**
     * @var int
     * @ORM\Column(type="integer", length=11, nullable=false)
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="App\Doctrine\ORM\Id\EmployeeIDGenerator")
     */
    protected $emp_no;

    /**
     * @var \DateTime|null
     * @ORM\Column(type="date", nullable=false)
     */
    protected $birth_date;

    /**
     * @var string|null
     * @ORM\Column(type="string", length=14, nullable=false)
     */
    protected $first_name;

    /**
     * @var string|null
     * @ORM\Column(type="string", length=16, nullable=false)
     */
    protected $last_name;

    /**
     * @var string|null
     * @ORM\Column(type="string", columnDefinition="ENUM('M', 'F')", nullable=false)
     */
    protected $gender;

    /**
     * @var \DateTime|null
     * @ORM\Column(type="date", nullable=false)
     */
    protected $hire_date;

    /**
     * @var SalaryEntity[]
     * @ORM\OneToMany(targetEntity="SalaryEntity", mappedBy="employee")
     */
    protected $salaries;

    /**
     * @var TitleEntity[]
     * @ORM\OneToMany(targetEntity="TitleEntity", mappedBy="employee")
     */
    protected $titles;

    /**
     * @var DepartmentEmployeeEntity[]
     * @ORM\OneToMany(targetEntity="DepartmentEmployeeEntity", mappedBy="employee")
     */
    protected $departmentEmployees;

    /**
     * @var DepartmentManagerEntity[]
     * @ORM\OneToMany(targetEntity="DepartmentManagerEntity", mappedBy="employee")
     */
    protected $departmentManagers;

    public function __construct() {
        $this->salaries = new ArrayCollection();
        $this->titles = new ArrayCollection();
        $this->departmentEmployees = new ArrayCollection();
        $this->departmentManagers = new ArrayCollection();
    }

    /**
     * @return int|null
     */
    public function getEmpNo(): ?int {
        return $this->emp_no;
    }

    /**
     * @param int|null $emp_no
     */
    public function setEmpNo(?int $emp_no): void {
        $this->emp_no = $emp_no;
    }

    /**
     * @return \DateTime|null
     */
    public function getBirthDate(): ?\DateTime {
        return $this->birth_date;
    }

    /**
     * @param \DateTime|null $birth_date
     */
    public function setBirthDate(?\DateTime $birth_date): void {
        $this->birth_date = $birth_date;
    }

    /**
     * @return string|null
     */
    public function getFirstName(): ?string {
        return $this->first_name;
    }

    /**
     * @param string|null $first_name
     */
    public function setFirstName(?string $first_name): void {
        $this->first_name = $first_name;
    }

    /**
     * @return string|null
     */
    public function getLastName(): ?string {
        return $this->last_name;
    }

    /**
     * @param string|null $last_name
     */
    public function setLastName(?string $last_name): void {
        $this->last_name = $last_name;
    }

    /**
     * @return string|null
     */
    public function getGender(): ?string {
        return $this->gender;
    }

    /**
     * @param string|null $gender
     */
    public function setGender(?string $gender): void {
        $this->gender = $gender;
    }

    /**
     * @return \DateTime|null
     */
    public function getHireDate(): ?\DateTime {
        return $this->hire_date;
    }

    /**
     * @param \DateTime|null $hire_date
     */
    public function setHireDate(?\DateTime $hire_date): void {
        $this->hire_date = $hire_date;
    }

    /**
     * @return SalaryEntity[]
     */
    public function getSalaries(): array {
        return $this->salaries;
    }

    /**
     * @param SalaryEntity[] $salaries
     */
    public function setSalaries(array $salaries): void {
        $this->salaries = $salaries;
    }

    /**
     * @return TitleEntity[]
     */
    public function getTitles(): array {
        return $this->titles;
    }

    /**
     * @param TitleEntity[] $titles
     */
    public function setTitles(array $titles): void {
        $this->titles = $titles;
    }

    /**
     * @return DepartmentEmployeeEntity[]
     */
    public function getDepartmentEmployees(): array {
        return $this->departmentEmployees;
    }

    /**
     * @param DepartmentEmployeeEntity[] $departmentEmployees
     */
    public function setDepartmentEmployees(array $departmentEmployees): void {
        $this->departmentEmployees = $departmentEmployees;
    }

    /**
     * @return DepartmentManagerEntity[]
     */
    public function getDepartmentManagers(): array {
        return $this->departmentManagers;
    }

    /**
     * @param DepartmentManagerEntity[] $departmentManagers
     */
    public function setDepartmentManagers(array $departmentManagers): void {
        $this->departmentManagers = $departmentManagers;
    }
}