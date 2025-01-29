<?php

namespace App\Classes;

use Illuminate\Http\Request;

class Pagination
{
    const DEFAULT_PAGE_SIZE = 10;
    const DEFAULT_SORT = '["id","ASC"]';

    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function getFilter(): array
    {
        $filterSe = $this->request->input('filter', null);
        $filter = json_decode($filterSe, true);

        if ($filter === null) {
            return [];
        } else {
            $result = [];
            foreach ($filter as $key => $value) {
                $result[] = [$key, 'like', '%' . $value . '%'];
            }
            return $result;
        }
    }

    public function getRange(): array
    {
        $rangeSe = $this->request->input('range', null);
        $range = json_decode($rangeSe, true);

        if ($range === null || count($range) !== 2) {
            return [0, self::DEFAULT_PAGE_SIZE - 1];
        } else {
            return $range;
        }
    }

    public function getSort(): array
    {
        $sortSe = $this->request->input('sort', null);
        $sort = json_decode($sortSe, true);

        if ($sort === null || count($sort) !== 2) {
            return json_decode(self::DEFAULT_SORT, true);
        } else {
            return $sort;
        }
    }
}
