<?php

namespace App\Repositories\Data;

interface DataRepositoryInterface
{
    public function getAll();

    public function getUniqueUsers();
}