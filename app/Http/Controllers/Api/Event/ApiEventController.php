<?php

namespace App\Http\Controllers\Api\Event;

use App\Entities\Event;
use App\Entities\Company;
use App\Entities\Group;
use App\Http\Controllers\BaseController;
use App\Services\Event\EventIndex;
use App\Transformers\Event\EventTransformer;
use App\User;
use Carbon\Carbon;
use Dingo\Api\Exception\StoreResourceFailedException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Session;

class ApiEventController extends BaseController
{
    
    /**
     * @var Event
     */
    protected $model;

    /**
     * EventController constructor.
     *
     * @param Event $model
     */
    public function __construct(Event $model)
    {
        $this->model = $model;

    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, EventIndex $eventIndex)
    {

        /*start cache settings*/
        $url = request()->url();
        $params = request()->query();
        $fullUrl = getFullCacheUrl($url, $params);
        $minutes = getCacheDuration('low'); 
        /*end cache settings*/

        //get the data
        $data = $eventIndex->getEvents($request);

        //are we in report mode?
        if (!$request->report) {

            $data = $this->response->paginator($data, new EventTransformer());

        } else {

            $data = $data->get();
            $data = $this->response->collection($data, new EventTransformer());

        }

        //return api data
        /*return Cache::remember($fullUrl, $minutes, function () use ($data) {
            return $data;
        });*/

        return $data;

    }


    /**
     * @param $id
     * @return mixed
    */
    public function show($id)
    {
        $item = $this->model->findOrFail($id);

        return $this->response->item($item, new EventTransformer());
    }


    /**
     * @param Request $request
     * @return mixed
    */
    public function store(Request $request)
    {

        $rules = [
            'event_cd' => 'required',
            'description' => 'required'
        ];

        $payload = app('request')->only('event_cd', 'description');
        $validator = app('validator')->make($payload, $rules);

        if ($validator->fails()) {
            throw new StoreResourceFailedException($validator->errors());
        }

        //create item
        $this->model->create($request->all());

        return ['message' => 'Event created.'];

    }


    /**
     * @param Request $request
     * @param $id
     * @return mixed
    */
    public function update(Request $request, $id)
    {

        $item = $this->model->findOrFail($id);

        $rules = [
            'event_cd' => 'required',
            'description' => 'required'
        ];

        $payload = app('request')->only('event_cd', 'description');
        $validator = app('validator')->make($payload, $rules);

        if ($validator->fails()) {
            throw new StoreResourceFailedException($validator->errors());
        }
        // update data fields
        $this->model->updatedata($id, $request->all());

        return $this->response->item($item->fresh(), new EventTransformer());

    }


    /**
     * @param Request $request
     * @param $id
     * @return mixed
    */
    public function destroy(Request $request, $id)
    {
        
        $user_id = auth()->user()->id;

        $item = $this->model->findOrFail($id);
        
        if ($item) {
            //update deleted by field
            $item->update(['deleted_by' => $user_id]);
            $result = $item->delete();
        }

        return $this->response->noContent();
    }

}
