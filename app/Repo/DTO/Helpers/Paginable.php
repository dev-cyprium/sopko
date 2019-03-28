<?php

namespace App\Repo\DTO\Helpers;

trait Paginable
{
    public $meta;

    /**
     * Injects paginator metadata into DTO
     * @param \Illuminate\Contracts\Pagination\LengthAwarePaginator $paginator
     */
    public function injectPaginationData($paginator)
    {
        $this->meta = [
            'total' => $paginator->total(),
            'current_page' => $paginator->currentPage(),
            'per_page' => $paginator->perPage(),
        ];
    }
}