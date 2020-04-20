<?php

namespace App\Http\Controllers\Api;

use App\Helper\Pagination;
use App\Http\Controllers\Controller;
use App\Http\Requests\UploadDataRequest;
use App\Http\Resources\DataResource;
use App\Jobs\UploadDataJob;
use App\Repositories\Data\DataRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    /**
     * @param UploadDataRequest $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function uploadData(UploadDataRequest $request)
    {
        UploadDataJob::dispatch(Auth::id(), $request->post('csv'));

        return response('successfully uploaded');
    }
}
