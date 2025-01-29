<?php

namespace App\Classes\ApiController;

use App\Classes\Pagination;
use Illuminate\Http\Request;

trait HasIndex
{
    use HasModel;

    public function index(Request $request)
    {
        $query = $this->model->query();

        $pagination = new Pagination($request);
        $pagination->applyFilter($query);

        $range = $pagination->getRange();
        $sort = $pagination->getSort();

        $count = $query->count();
        $items = $query
            ->orderBy($sort[0], $sort[1])
            ->skip($range[0])
            ->take($range[1] - $range[0] + 1)
            ->get();

        return response()->json($items, 200, [
            'Content-Range' => $count,
        ]);
    }

}
