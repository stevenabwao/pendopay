<?php

namespace App\Http\Controllers\Api\Wards;

use App\Entities\Ward;
use App\Http\Controllers\Controller;
use App\Transformers\Wards\WardTransformer;
use Carbon\Carbon;
use Dingo\Api\Exception\StoreResourceFailedException;
use Dingo\Api\Http\Response\paginator;
use Dingo\Api\Routing\Helpers;
use Illuminate\Database\Eloquent\paginate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Class WardsController.
 *
 */
class WardsController extends Controller
{
    use Helpers;

    /**
     * @var Ward
     */
    protected $model;

    /**
     * WardsController constructor.
     *
     * @param Ward $model
     */
    public function __construct(Ward $model)
    {
        $this->model = $model;

        $this->middleware('permission:Create acls')->only('store');
        $this->middleware('permission:Update acls')->only('update');
        $this->middleware('permission:Delete acls')->only('destroy');
    }

    public function index(Request $request)
    {

        //are we in report mode?
        $report = $request->report;
        $state_id = $request->state_id;

        $wards = new Ward();

        if ($state_id) {
            //get state wards
            $wards = $wards->where('state_id', $state_id);
        }

        $wards = $wards->orderBy('name', 'asc');
        
        if (!$report) {
            $wards = $wards->paginate('limit', $request->get('limit', config('app.pagination_limit')));

            return $this->response->paginator($wards, new WardTransformer());
        }

        $wards = $wards->get();

        return $this->response->collection($wards, new WardTransformer);

    }

    /**
     * @param $id
     * @return mixed
     */
    public function show($id)
    {
        $ward = $this->model->findOrFail($id);

        return $this->response->item($ward, new WardTransformer());
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request)
    {

        $rules = [
            'name' => 'required',
            'constituency_id' => 'required|integer',
        ];

        $payload = app('request')->only('name', 'constituency_id');

        $validator = app('validator')->make($payload, $rules);

        if ($validator->fails()) {
            throw new StoreResourceFailedException('Could not create new ward.', $validator->errors());
        }

        //create ward
        $user_id = auth()->user()->id;
        $request->created_by = $user_id;
        $request->updated_by = $user_id;

        $ward = $this->model->create($request->all());

        //return $this->response->created();
        return ['message' => 'Ward created'];

    }

    /**
     * @param Request $request
     * @param $id
     */
    public function update(Request $request, $id)
    {
        
        $ward = $this->model->find($id);
        $rules = [
            'name' => 'required',
            'constituency_id' => 'required|integer'
        ];
        if ($request->method() == 'PATCH') {
            $rules = [
                'name' => 'sometimes|required',
                'constituency_id' => 'sometimes|required|integer'
            ];
        }

        $payload = app('request')->only('name', 'constituency_id');

        $validator = app('validator')->make($payload, $rules);

        if ($validator->fails()) {
            $error_messages = formatValidationErrors($validator->errors());
            throw new StoreResourceFailedException($error_messages);
        }

        //update record
        $user_id = auth()->user()->id;
        $request->updated_by = $user_id;

        $ward->update($request);

        return $this->response->item($ward->fresh(), new WardTransformer());

    }

    /**
     * @param Request $request
     * @param $id
     */
    public function destroy(Request $request, $id)
    {
        $ward = $this->model->find($id);
        $ward->delete();

        return $this->response->noContent();
    }
}
