<?php

namespace App\Http\Controllers\Api\ChannelEvent;

use App\Entities\ChannelEvent;
use App\Http\Controllers\BaseController;
use App\Services\ChannelEvent\ChannelEventIndex;
use App\Transformers\ChannelEvent\ChannelEventTransformer;
use App\User;
use Carbon\Carbon;
use Dingo\Api\Exception\StoreResourceFailedException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Session;

class ApiChannelEventController extends BaseController
{
    
    /**
     * @var ChannelEvent
     */
    protected $model;

    /**
     * ChannelEventController constructor.
     *
     * @param ChannelEvent $model
     */
    public function __construct(ChannelEvent $model)
    {
        $this->model = $model;

    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, ChannelEventIndex $channelEventIndex)
    {

        /*start cache settings*/
        $url = request()->url();
        $params = request()->query();
        $fullUrl = getFullCacheUrl($url, $params);
        $minutes = getCacheDuration('low'); 
        /*end cache settings*/

        //get the data
        $data = $channelEventIndex->getCharges($request);

        //are we in report mode?
        if (!$request->report) {

            $data = $this->response->paginator($data, new ChannelEventTransformer());

        } else {

            $data = $data->get();
            $data = $this->response->collection($data, new ChannelEventTransformer());

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

        return $this->response->item($item, new ChannelEventTransformer());
    }


    /**
     * @param Request $request
     * @return mixed
    */
    public function store(Request $request)
    {

        $rules = [
            'channel_id' => 'required',
            'event_id' => 'required'
        ];

        $payload = app('request')->only('channel_id', 'event_id');
        $validator = app('validator')->make($payload, $rules);

        if ($validator->fails()) {
            throw new StoreResourceFailedException($validator->errors());
        }

        //create item
        $this->model->create($request->all());

        return ['message' => 'ChannelEvent created.'];

    }


    /**
     * @param Request $request
     * @param $id
     * @return mixed
    */
    public function update(Request $request, $id)
    {

        $rules = [
            'channel_id' => 'required',
            'event_id' => 'required'
        ];

        $payload = app('request')->only('channel_id', 'event_id');
        $validator = app('validator')->make($payload, $rules);

        if ($validator->fails()) {
            throw new StoreResourceFailedException($validator->errors());
        }
        
        // update data fields
        $this->model->updatedata($id, $request->all());

        return $this->response->item($item->fresh(), new ChannelEventTransformer());

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
