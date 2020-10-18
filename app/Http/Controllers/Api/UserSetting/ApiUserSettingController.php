<?php

namespace App\Http\Controllers\Api\UserSetting;

use App\Entities\UserSetting;
use App\Services\UserSetting\UserSettingIndex;
use App\Services\UserSetting\UserSettingStore;
use App\Services\UserSetting\UserSettingShow;
use App\Services\UserSetting\UserSettingApprove;
use App\Services\UserSetting\UserSettingUpdate;
use App\Http\Controllers\BaseController;
use App\Transformers\UserSetting\UserSettingTransformer;
use App\User;
use Carbon\Carbon;
use Dingo\Api\Exception\StoreResourceFailedException;
use Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Session;
use Illuminate\Support\Facades\DB;

class ApiUserSettingController extends BaseController
{

    /**
     * @var state
     */
    protected $model;

    /**
     * UserSettingController constructor.
     *
     * @param UserSetting $model
     */
    public function __construct(UserSetting $model)
    {
        $this->model = $model;

    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, UserSettingIndex $userSettingIndex)
    {


        DB::enableQueryLog();

        //get the data
        $data = $userSettingIndex->getData($request);

        //are we in report mode?
        if (!$request->report) {

            $data = $this->response->paginator($data, new UserSettingTransformer());

        } else {

            $data = $data->get();
            $data = $this->response->collection($data, new UserSettingTransformer());

        }

        // dd(DB::getQueryLog());

        //return api data
        /* return Cache::remember($fullUrl, $minutes, function () use ($data) {
            return $data;
        }); */

        return $data;

    }


    /**
     * @param $id
     * @return mixed
    */
    public function show($id)
    {
        // $item = $this->model->find($id);
        $item = $this->model->where("user_id", $id)->first();

        if (!$item) {
            // return 404 error
            return response()->json(['message' => 'Not Found.'], 404);
        }

        return $this->response->item($item, new UserSettingTransformer());
    }


    /**
     * @param Request $request
     * @return mixed
    */
    public function store(Request $request, UserSettingStore $userSettingStore)
    {

        $rules = [
            'user_id' => 'required'
        ];

        $payload = app('request')->only('user_id');
        $validator = app('validator')->make($payload, $rules);

        if ($validator->fails()) {
            throw new StoreResourceFailedException($validator->errors());
        }

        //create item
        try{
            $userSetting = $userSettingStore->createItem($request);
        } catch (\Exception $e) {
            // dd($e);
            $message = "Error creating user settings";
            return show_error($message);
        }

        $result_json = json_decode($userSetting);

        // dd($result_json);
        $error = $result_json->error;
        $message = $result_json->message;

        // vget message
        $response = $message->message;

        if ($error){
            return show_error($response);
        } else {
            return show_success($response);
        }   

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
