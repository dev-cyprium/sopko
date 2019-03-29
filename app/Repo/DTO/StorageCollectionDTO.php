<?php

namespace App\Repo\DTO;
use App\Repo\DTO\BaseDTO;
use App\Repo\DTO\Helpers\Paginable;

class StorageCollectionDTO extends BaseDTO
{
    use Paginable;

    public $storages;

    /**
     * @param array $products The product array
     * @param \Illuminate\Contracts\Pagination\LengthAwarePaginator $paginationData
     */
    public function __construct($storages, $paginationData)
    {
        $this->storages = $storages;
        $this->injectPaginationData($paginationData);
    }
}