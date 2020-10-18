<?php

namespace App\Http\Controllers\Web\ManageData;

use Illuminate\Http\Request;
use App\Entities\Group;
use App\Entities\Country;
use App\User;
use App\Entities\Company;
use App\Entities\CompanyBranch;
use App\Entities\BranchMember;
use App\Entities\ManageData;
use App\Entities\BranchGroup;
use App\Services\ManageData\ManageDataIndex;

use Session;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;

class ManageDataController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function manage(Request $request, ManageDataIndex $manageDataIndex)
    {

        //get the data
        $data = $manageDataIndex->getData($request);

        return true; 

    }

}
