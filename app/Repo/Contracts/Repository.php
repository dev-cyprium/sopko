<?php

namespace App\Repo\Contracts;

interface Repository
{
    /**
     * Return all of the entities
     * 
     * @return array
     */
    public function getAll();
}