<?php

namespace App\Http\Controllers\Web\Events;

use App\Entities\Event;
use App\Entities\Status;
use App\Services\Event\EventIndex;
use App\Http\Controllers\Controller;
use App\User;
use Carbon\Carbon;
use Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Session;

class EventController extends Controller
{
    
    /**
     * @var state
     */
    protected $model;

    /**
     * LoanApplicationController constructor.
     *
     * @param LoanApplication $model
     */
    public function __construct(Event $model)
    {
        $this->model = $model;

    }

    /**
     *
     * @param Request $request
     * @return mixed
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

        //are we in report mode? return get results
        if ($request->report) {

            $data = $data->get(); 

        }

        //return cached data or cache if cached data not exists
        //return Cache::remember($fullUrl, $minutes, function () use ($data) {
            return view('manage.events.index', [
                'events' => $data->appends(Input::except('page'))
            ]);
        //});

    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $statuses = Status::all();

        return view('manage.events.create', compact('statuses'));

    }

    /**
     * @param $id
     * @return mixed
    */
    public function show($id)
    {
        $event = $this->model->findOrFail($id);

        //Log::info('event ', $event->toArray());
        
        return view('manage.events.show', compact('event'));

    }

    /**
     * @param Request $request
     * @return mixed
    */
    public function store(Request $request)
    {

        $rules = [
            'event_cd' => 'required',
            'status_id' => 'required',
            'name' => 'required'
        ];

        $payload = app('request')->only('event_cd', 'status_id', 'name');

        $validator = app('validator')->make($payload, $rules);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator->errors());
        }

        //dd($request);

        //create item
        $event = $this->model->create($request->all());

        Session::flash('success', 'Successfully created new event - ' . $event->name);
        return redirect()->route('events.index');

    }

    public function edit($id)
    {
        
        $event = event::findOrFail($id);
        $statuses = Status::all();

        return view('manage.events.edit', compact('event', 'statuses'));

    }


    /**
     * @param Request $request
     * @param $id
     * @return mixed
    */
    public function update(Request $request, $id)
    {
        
        $event = $this->model->findOrFail($id);

        $rules = [
            'event_cd' => 'required',
            'event_cat_ty' => 'required',
            'start_at' => 'required',
            'name' => 'required'
        ];

        $payload = app('request')->only('event_cd', 'event_cat_ty', 'start_at', 'name');

        $validator = app('validator')->make($payload, $rules);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator->errors());
        }

        // update fields
        $this->model->updatedata($id, $request->all());

        Session::flash('success', 'Successfully updated event - ' . $event->name);
        return redirect()->route('events.show', $event->id);

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

        return redirect()->route('events.index');
    }

}
