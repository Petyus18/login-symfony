<?php

namespace App\Builder;

use Symfony\Component\HttpFoundation\Request;

use App\DataObject\ListRequestData;

class ListRequestDataBuilder {

    public const ORDER_COLUMN = 'column';
    public const ORDER_DIR = 'dir';
    public const DATA = 'data';
    public const VALUE = 'value';
    public const SEARCHABLE = 'searchable';
    public const SEARCH = 'search';
    public const ORDER = 'order';
    public const COLUMNS = 'columns';
    public const START = 'start';
    public const LENGTH = 'length';

    /**
     * @param Request $request
     * @return ListRequestData
     */
    public function build(Request $request): ListRequestData {
        $columns = $request->get(self::COLUMNS);
        $requestOrder = $request->get(self::ORDER);

        return new ListRequestData(
            $request->get(self::START),
            $request->get(self::LENGTH),
            $this->buildRequestOrderData($requestOrder, $columns),
            $this->buildFieldSearchData($columns)
        );
    }

    /**
     * @param array $columns
     * @return array
     */
    protected function buildFieldSearchData(array $columns): array {
        $fieldSearch = [];
        foreach ($columns as $column) {
            if (TRUE == (boolean)$column[self::SEARCHABLE] && '' !== $column[self::SEARCH][self::VALUE]) {
                $fieldSearch[$column[self::DATA]] = $column[self::SEARCH][self::VALUE];
            }
        }

        return $fieldSearch;
    }

    /**
     * @param array $requestOrder
     * @param array $columns
     * @return array
     */
    protected function buildRequestOrderData(array $requestOrder, array $columns): array {
        $orders = [];
        foreach ($requestOrder as $order) {
            if (isset($columns[$order[self::ORDER_COLUMN]])) {
                $field = $columns[$order[self::ORDER_COLUMN]][self::DATA];
                $orders[$field] = $order[self::ORDER_DIR];
            }
        }

        return $orders;
    }
}