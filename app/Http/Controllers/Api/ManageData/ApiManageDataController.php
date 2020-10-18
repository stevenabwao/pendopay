<?php

namespace App\Http\Controllers\Api\ManageData;

use Illuminate\Http\Request;
use App\Services\ManageData\ManageDataIndex;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ApiManageDataController extends Controller
{

    public function manage(Request $request, ManageDataIndex $manageDataIndex)
    {

        //dd($request);
        DB::beginTransaction();

        //get the data
        try {

            $data = $manageDataIndex->getData($request);

            return ['message' => 'Successfully executed'];

            //dd($data);
        } catch(\Exception $e) {

            DB::rollback();
            // dd($e);
            log_this(json_encode($e->getMessage()));

        }

        DB::commit();

    }

}
