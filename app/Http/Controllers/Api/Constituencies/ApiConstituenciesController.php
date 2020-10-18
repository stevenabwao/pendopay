<?php

namespace App\Http\Controllers\Api\Constituencies;

use App\Entities\Constituency;
use App\Http\Controllers\Controller;
use App\Transformers\Constituencies\ConstituencyTransformer;
use Carbon\Carbon;
use Dingo\Api\Exception\StoreResourceFailedException;
use Dingo\Api\Http\Response\paginator;
use Dingo\Api\Routing\Helpers;
use Illuminate\Database\Eloquent\paginate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Class ApiConstituenciesController.
 *
 */
class ApiConstituenciesController extends Controller
{
    use Helpers;

    /**
     * @var Constituency
     */
    protected $model;

    /**
     * ConstituenciesController constructor.
     *
     * @param Constituency $model
     */
    public function __construct(Constituency $model)
    {
        $this->model = $model;
    }

    public function index(Request $request)
    {

        //are we in report mode?
        $report = $request->report;
        $constituency_id = $request->constituency_id;

        $constituencies = new Constituency();

        if ($constituency_id) {
            //get constituency
            $constituencies = $constituencies->where('id', $constituency_id);
        }

        $constituencies = $constituencies->orderBy('name', 'asc');

        if (!$report) {
            $constituencies = $constituencies->paginate('limit', $request->get('limit', config('app.pagination_limit')));

            return $this->response->paginator($constituencies, new ConstituencyTransformer());
        }

        $constituencies = $constituencies->get();

        return $this->response->collection($constituencies, new ConstituencyTransformer);

    }

    /**
     * @param $id
     * @return mixed
     */
    public function show($id)
    {
        $constituency = $this->model->findOrFail($id);

        return $this->response->item($constituency, new ConstituencyTransformer());
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request)
    {

        $rules = [
            'name' => 'required',
            'state_id' => 'required|integer',
        ];

        $payload = app('request')->only('name', 'state_id');

        $validator = app('validator')->make($payload, $rules);

        if ($validator->fails()) {
            throw new StoreResourceFailedException('Could not create new constituency.', $validator->errors());
        }

        //create ward
        $user_id = auth()->user()->id;
        $request->created_by = $user_id;
        $request->updated_by = $user_id;

        $constituency = $this->model->create($request->all());

        return ['message' => 'Constituency created'];

    }

    /**
     * @param Request $request
     * @param $id
     */
    public function update(Request $request, $id)
    {
        
        $constituency = $this->model->find($id);
        $rules = [
            'name' => 'required',
            'state_id' => 'required|integer'
        ];
        if ($request->method() == 'PATCH') {
            $rules = [
                'name' => 'sometimes|required',
                'state_id' => 'sometimes|required|integer'
            ];
        }

        $payload = app('request')->only('name', 'state_id');

        $validator = app('validator')->make($payload, $rules);

        if ($validator->fails()) {
            $error_messages = formatValidationErrors($validator->errors());
            throw new StoreResourceFailedException($error_messages);
        }

        //update record
        $user_id = auth()->user()->id;
        $request->updated_by = $user_id;

        $constituency->update($request);

        return $this->response->item($constituency->fresh(), new ConstituencyTransformer());

    }

    /**
     * @param Request $request
     * @param $id
     */
    public function destroy(Request $request, $id)
    {
        $constituency = $this->model->find($id);
        $constituency->delete();

        return $this->response->noContent();
    }
}
