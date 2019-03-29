<?php

namespace App\Repo\Contracts;

use App\Repo\DTO\ProductCollectionDTO;

interface ProductContract extends Repository
{
    /**
     * Binds the images to the stored model.
     * Must be called after $this->model is saved
     * to the database.
     */
    public function bindImages(array $imageHashs) : void;

    /**
     * Creates a new price for a product set 
     * by the Repository
     */
    public function newPrice(float $price, string $slug = null) : void;

    /**
     * Sets the storage to the product set
     * by the Repository
     */
    public function bindStorage(int $idStorage, int $quantity) : void;

    /**
     * Sets the sales to the product
     * set by the Repositry
     */
    public function bindSales(array $sales) : void;

    /**
     * Sets the user groups for the product
     * set by the Repository
     */
    public function bindUserGroups(array $groups) : void;

    /**
     * Get the scope for a specific group and prices
     * scoped to that group
     */
    public function getGroupScope($groupName) : ProductCollectionDTO;

    /**
     * Attach category ids array
     */
    public function bindCategoryIds(array $ids) : void;
}
