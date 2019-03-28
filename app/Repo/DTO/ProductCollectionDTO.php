<?php

namespace App\Repo\DTO;
use App\Repo\DTO\BaseDTO;
use App\Repo\DTO\Helpers\Paginable;

class ProductCollectionDTO extends BaseDTO
{
    use Paginable;

    public $products;

    /**
     * @param array $products The product array
     * @param \Illuminate\Contracts\Pagination\LengthAwarePaginator $paginationData
     */
    public function __construct($products, $paginationData)
    {
        $this->products = $products;
        $this->injectPaginationData($paginationData);
    }
}