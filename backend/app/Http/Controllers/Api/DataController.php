<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\DataResource;
use App\Repositories\Data\DataRepositoryInterface;

class DataController extends Controller
{
    private $userRepository;

    public function __construct(DataRepositoryInterface $user)
    {
        parent::__construct();
        $this->userRepository = $user;
    }

    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function getUsers()
    {
        $data = $this->userRepository->getAll();
        return DataResource::collection($data);
    }
}
