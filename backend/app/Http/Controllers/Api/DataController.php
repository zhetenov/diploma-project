<?php

namespace App\Http\Controllers\Api;

use App\Helper\Pagination;
use App\Http\Controllers\Controller;
use App\Http\Resources\DataResource;
use App\Repositories\Data\DataRepositoryInterface;
use Illuminate\Http\Request;

class DataController extends Controller
{
    private $userRepository;

    public function __construct(DataRepositoryInterface $user)
    {
        parent::__construct();
        $this->middleware('auth');
        $this->userRepository = $user;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function getUsers(Request $request)
    {
        $data  = $this->userRepository->getUniqueUsers();
        $items = Pagination::paginate($data, 15, $request->get('page'));

        return DataResource::collection($items);
    }
}
