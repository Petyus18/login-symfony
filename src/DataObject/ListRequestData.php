<?php

namespace App\DataObject;

class ListRequestData {

    /**
     * @var int
     */
    protected $start;

    /**
     * @var int
     */
    protected $length;

    /**
     * @var string[]
     */
    protected $orders;

    /**
     * @var string[]
     */
    protected $filedSearch = [];

    /**
     * @param int $start
     * @param int $length
     * @param string[] $orders
     * @param string[] $filedSearch
     */
    public function __construct(int $start,
                                int $length,
                                array $orders,
                                array $filedSearch) {
        $this->start = $start;
        $this->length = $length;
        $this->orders = $orders;
        $this->filedSearch = $filedSearch;
    }

    /**
     * @return int
     */
    public function getStart(): int {
        return $this->start;
    }

    /**
     * @return int
     */
    public function getLength(): int {
        return $this->length;
    }

    /**
     * @return array
     */
    public function getOrders(): array {
        return $this->orders;
    }

    /**
     * @return string[]
     */
    public function getFiledSearch(): array {
        return $this->filedSearch;
    }

    /**
     * @return bool
     */
    public function hasFieldSearch(): bool {
        return !empty($this->filedSearch);
    }
}