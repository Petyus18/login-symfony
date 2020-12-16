<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(name="departments")
 */
class DepartmentEntity {

    /**
     * @var string
     * @ORM\Column(type="string", length=4, nullable=false)
     * @ORM\Id()
     */
    protected $dept_no;

    /**
     * @var string
     * @ORM\Column(type="string", length=40, nullable=false, unique=true)
     */
    protected $dept_name;

    /**
     * @return string
     */
    public function getDeptNo(): string {
        return $this->dept_no;
    }

    /**
     * @param string $dept_no
     */
    public function setDeptNo(string $dept_no): void {
        $this->dept_no = $dept_no;
    }

    /**
     * @return string
     */
    public function getDeptName(): string {
        return $this->dept_name;
    }

    /**
     * @param string $dept_name
     */
    public function setDeptName(string $dept_name): void {
        $this->dept_name = $dept_name;
    }
}