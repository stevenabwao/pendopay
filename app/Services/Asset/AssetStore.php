<?php

namespace App\Services\Asset;

use App\Entities\Company;
use App\Entities\Asset;
use App\User;
use Carbon\Carbon;
use Dingo\Api\Exception\StoreResourceFailedException;
use Dingo\Api\Routing\Helpers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Input;

class AssetStore
{

    use Helpers;

    public function createItem($attributes) {


        //current date and time
        $date = Carbon::now();
        //$date = getLocalDate($date);
        //$date = $date->toDateTimeString();

        DB::beginTransaction();

            $asset_url = "";
            $event_map_id = "";
            $status_id = "";
            $asset_type_id = "";

            //get Asset data
            $company_id = $attributes['company_id'];
            $name = $attributes['name'];

            if (array_key_exists('asset_url', $attributes)) {
                $asset_url = $attributes['asset_url'];
            }

            if (array_key_exists('event_map_id', $attributes)) {
                $event_map_id = $attributes['event_map_id'];
            }

            if (array_key_exists('asset_type_id', $attributes)) {
                $asset_type_id = $attributes['asset_type_id'];
            }

            //start create new asset
            //set attributes
            $asset_attributes['asset_url'] = $asset_url;
            $asset_attributes['company_id'] = $company_id;
            $asset_attributes['name'] = $name;
            if ($asset_type_id) {
                $asset_attributes['asset_type_id'] = $asset_type_id;
            }
            if ($event_map_id) {
                $asset_attributes['ussd_event_map_id'] = $event_map_id;
            }
            if ($status_id) {
                $asset_attributes['ussd_status_id'] = $status_id;
            }

            //dd($asset_attributes);

            //upload the file
            try{

                /*
                if (request()->hasFile('asset_url')) {
                    $image = request()->file('asset_url');
                    //$name = getStrSlug($request->title).'.'.$image->getClientOriginalExtension();
                    $file_slug = getStrSlug(time());
                    $filename = $file_slug. '.' . $extension;
                    // $destinationPath = public_path('/public/download/forms/');
                    // $fullPath = '/public/download/forms/';
                    // $imagePath = $destinationPath. "/".  $filename;
                    // $image->move($destinationPath, $name);
                    // $asset_attributes['asset_url'] = $fullPath . $filename;

                    $path = "/download/forms/";
                    if(!Storage::disk('public_uploads')->put($path, $image)) {
                        return false;
                    }

                    dd($attributes, $asset_attributes);
                }
                */

                $extension = Input::file('asset_url')->getClientOriginalExtension();
                $file_slug = getStrSlug(time());
                $filename = $file_slug. '.' . $extension;
                //$filepath = base_path().'/public/download/forms/'. $filename;
                $filepath= base_path().'/public/download/forms/';
                $asset_attributes['asset_url'] = $filepath;
                //dd($attributes, $asset_attributes);
                //Input::file('asset_url')->move($filepath);
                $fullPath = '/public/download/forms/';

                $file = request()->file('asset_url');
                dd($file);
                $fileName = md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();
                $file_upload_name = $asset_attributes['asset_url'];
                $file->move($filepath, $fileName);

                //save to db
                $asset = new Asset($asset_attributes);
                $response = $asset->save();
                $response = show_json_success($response);
                dd($response);

            } catch(\Exception $e) {

                DB::rollback();
                $message = $e->getMessage();
                return show_json_error($message);

            }
            //end create new asset

        DB::commit();

        return $response;

    }

}
