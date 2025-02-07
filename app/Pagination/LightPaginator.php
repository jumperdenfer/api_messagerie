<?php 
namespace App\Pagination;
use Illuminate\Pagination\LengthAwarePaginator;

class LightPaginator extends LengthAwarePaginator
{
    public function toArray()
    {
        return [
            "data" => $this->items->toArray(),
            "total" => $this->total()
        ];
    }

}