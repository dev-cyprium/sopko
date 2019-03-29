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
            'total' => (int) $paginator->total(),
            'current_page' => (int) $paginator->currentPage(),
            'per_page' => $paginator->perPage(),
        ];
    }
}