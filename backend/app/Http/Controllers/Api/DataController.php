<?php

namespace App\Http\Controllers\Api;

use App\Helper\Pagination;
use App\Http\Controllers\Controller;
use App\Http\Requests\UploadDataRequest;
use App\Http\Resources\DataResource;
use App\Http\Resources\UserResource;
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
        $items = Pagination::paginate($data, 7, $request->get('page'));

        return DataResource::collection($items);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function getUsersWihoutGraph(Request $request)
    {
        $data  = $this->userRepository->getUniqueUsers();
        if($request->get('name')) {
            $data = $data->where('name', $request->get('name'));
        }
        if($request->get('email')) {
           $data = $data->where('email', $request->get('email'));
        }
        if($request->get('rfm')) {
            $data = $data->where('score', $request->get('rfm'));
        }
        $items = Pagination::paginate($data, 7, $request->get('page'));

        return UserResource::collection($items);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function getUsersWihoutGraphFile(Request $request)
    {
        $data  = $this->userRepository->getUniqueUsers();
        if($request->get('name')) {
            $data = $data->where('name', $request->get('name'));
        }
        if($request->get('email')) {
           $data = $data->where('email', $request->get('email'));
        }
        if($request->get('rfm')) {
            $data = $data->where('score', $request->get('rfm'));
        }
        if(count($data) == 0) {
            return response('no file', 200, [
                'Content-Type' => 'text/csv',
                'Content-Transfer-Encoding' => 'binary',
                'Content-Disposition' => 'attachment; filename="people.csv"',
            ]);
        }
        $csv = \League\Csv\Writer::createFromFileObject(new \SplTempFileObject);
        $csv->insertOne(array_keys($data[0]->getAttributes()));
        foreach ($data as $line) {
            $csv->insertOne($line->toArray());
        }

        return response((string) $csv->output('people.csv'), 200, [
            'Content-Type' => 'text/csv',
            'Content-Transfer-Encoding' => 'binary',
            'Content-Disposition' => 'attachment; filename="people.csv"',
        ]);
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
