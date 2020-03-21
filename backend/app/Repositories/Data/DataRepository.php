<?php

namespace App\Repositories\Data;

use App\Models\Data;
use Illuminate\Support\Facades\Auth;
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

    public function getUniqueUsers()
    {
        $users = $this->startConditions()
            ->where('user_id', Auth::id())
            ->orderBy('created_at')
            ->get();

        $uniqueUsers = $users->unique('client_id');

        return $uniqueUsers;
    }
}
