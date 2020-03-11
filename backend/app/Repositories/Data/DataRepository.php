<?php

namespace App\Repositories\Data;

use App\Models\Data;
use Zhetenov\Repository\BaseRepository;

class DataRepository extends BaseRepository implements DataRepositoryInterface
{
    /**
     * Returns current model.
     *
     * @return string
     */
    protected function getModelClass(): string
    {
        return Data::class;
    }

    public function getAll()
    {
        return $this->startConditions()
            ->get();
    }
}
