<?php

namespace App\Services\SupervisorClientAssign;

use App\Entities\SupervisorClientAssign;
use App\Entities\SupervisorClientAssignDetail;
use App\Entities\Product;
use App\Entities\Company;
use App\Entities\CompanyUser;
use App\Services\Setting\LoanSetting\LoanSettingStore;
use App\Services\GlAccount\GlAccountStore;
use Carbon\Carbon;
use Dingo\Api\Exception\StoreResourceFailedException;
use Dingo\Api\Routing\Helpers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SupervisorClientAssignRemove {

    use Helpers;

    public function createItem($attributes) {

        $status_active = config('constants.status.active');

        DB::beginTransaction();

            $supervisor_id = "";
            $usersSelected = "";

            $auth_user = auth()->user();
            $auth_user_id = $auth_user->id;
            $auth_user_first_name = $auth_user->first_name;
            $auth_user_last_name = $auth_user->last_name;
            $auth_user_full_names = $auth_user_first_name . " " . $auth_user_last_name;
            
            if (array_key_exists('supervisor_id', $attributes)) {
                $supervisor_id = $attributes['supervisor_id'];
            }
            if (array_key_exists('assignedUsersSelected', $attributes)) {
                $assignedUsersSelected = $attributes['assignedUsersSelected'];
            }

            // get client ids
            $client_ids_array = explode(",", $assignedUsersSelected);
            // dd($client_ids_array);
            
            // get supervisor data
            $supervisor_data = CompanyUser::find($supervisor_id);
            $company_supervisor_id = $supervisor_id;
            $supervisor_company_id = $supervisor_data->company_id;
            $supervisor_company_name = $supervisor_data->company->name;
            $supervisor_first_name = $supervisor_data->user->first_name;
            $supervisor_last_name = $supervisor_data->user->last_name;
            $supervisor_full_names = $supervisor_first_name . " " . $supervisor_last_name;
            // dump($supervisor_data, $company_supervisor_id);

            // start remove supervisor client assign record
            /* try {

                // start check if supervisor record exists in company 
                $supervisor_assigned_data = SupervisorClientAssign::where('company_supervisor_id', $supervisor_id)
                                            ->where('company_id', $supervisor_company_id)
                                            ->where('status_id', $status_active)
                                            ->first();
                
                if (!$supervisor_assigned_data) {

                    //create new supervisor record
                    try {

                        $new_supervisor_client_assign = new SupervisorClientAssign();
                        $assign_attributes['company_supervisor_id'] = $supervisor_id;
                        $assign_attributes['company_id'] = $supervisor_company_id;
                        $assign_attributes['created_by'] = $auth_user_id;
                        $assign_attributes['created_by_name'] = $auth_user_full_names;
                        $assign_attributes['updated_by'] = $auth_user_id;
                        $assign_attributes['updated_by_name'] = $auth_user_full_names;

                        //dd($assign_attributes);

                        $supervisor_assigned_data = $new_supervisor_client_assign->create($assign_attributes);

                        $supervisor_client_assign_id = $supervisor_assigned_data->id;

                        log_this(">>>>>>>>> SNB SUCCESS ASSIGNING USER TO SUPERVISOR :\n\n" . json_encode($supervisor_assigned_data) . "\n\n\n");
                        $response["message"] = $supervisor_assigned_data;

                    } catch(\Exception $e) {

                        DB::rollback();
                        //dd($e);
                        $message = $e->getMessage();
                        log_this(">>>>>>>>> SNB ERROR CREATING SUPERVISOR ASSIGN ENTRY :\n\n" . $message . "\n\n\n");
                        $response["message"] = $message;
                        return show_json_error($response);
        
                    }

                } else {

                    //record exists
                    $supervisor_client_assign_id = $supervisor_assigned_data->id;

                }

                $response["message"] = $supervisor_assigned_data;

            } catch (\Exception $e) {

                DB::rollback();
                //dd($e);
                $message = $e->getMessage();
                log_this(">>>>>>>>> SNB ERROR GETTING SUPERVISOR RECORD :\n\n" . $message . "\n\n\n");
                $response["message"] = $message;
                return show_json_error($response);
                
            } */
            //end create main supervisor client assign record

            //dd($client_ids_array, $supervisor_company_id);

            $count = 0;

            //start create client records
            foreach ($client_ids_array as $client_id) {

                //start check if client is belongs to supervisor company
                $client_data = CompanyUser::where('id', $client_id)
                                ->where('company_id', $supervisor_company_id)
                                ->first();
                $client_company_user_id = $client_data->id;
                $client_company_id = $client_data->company_id;
                $client_first_name = $client_data->user->first_name;
                $client_last_name = $client_data->user->last_name;
                $client_full_names = $client_first_name . " " . $client_last_name;

                //if client exists, proceed
                if ($client_data) {

                    try {

                        //start check if client is already assigned to company and is active
                        $client_assigned_data = SupervisorClientAssignDetail::where('company_user_id', $client_id)
                                                ->where('company_supervisor_id', $supervisor_id)
                                                // ->where('status_id', $status_active)
                                                ->first();
                                               // dd($client_assigned_data);
                        
                        if ($client_assigned_data) {

                            //client is assigned, delete record
                            try {

                                $client_assigned_data->delete();
                                
                                log_this(">>>>>>>>> SNB SUCCESS UNASSIGNING USER FROM SUPERVISOR :\n\n" . json_encode($client_assigned_data) . "\n\n\n");
                                

                                //unassign company user
                                updateCompanyUserAssign($client_company_user_id, $client_company_id, $supervisor_id, "99");

                                //update clients count for supervisor
                                updateSupervisorClientAssignCount($supervisor_id, $supervisor_company_id);

                            } catch(\Exception $e) {

                                DB::rollback();
                                //dd($e);
                                $message = $e->getMessage();
                                log_this(">>>>>>>>> SNB ERROR UNASSIGNING USER FROM SUPERVISOR :\n\n" . $message . "\n\n\n");
                                $response["message"] = $message;
                                return show_json_error($response);
                
                            }

                        } else {
                            
                            //error
                            $assigned_supervisor_first_name = $client_assigned_data->companyuser->user->first_name;
                            $assigned_supervisor_last_name = $client_assigned_data->companyuser->user->last_name;
                            $assigned_supervisor_full_names = $assigned_supervisor_first_name . " " . $assigned_supervisor_last_name;

                            DB::rollback();
                            $message = "Client with id " . $client_full_names . " is not assigned to supervisor: " . $assigned_supervisor_full_names;
                            log_this(">>>>>>>>> SNB ERROR UNASSIGNING USER - NOT ASSIGNED :\n\n" . $message . "\n\n\n");
                            $response["message"] = $message;
                            return show_json_error($response);

                        }

                    } catch (\Exception $e) {

                        DB::rollback();
                        //dd($e);
                        $message = $e->getMessage();
                        log_this(">>>>>>>>> SNB ERROR UNASSIGNING CLIENT FROM SUPERVISOR :\n\n" . $message . "\n\n\n");
                        $response["message"] = $message;
                        return show_json_error($response);
                        
                    }


                } else {
                    //error
                    DB::rollback();
                    $message = "Client " . $client_full_names . " must belong to supervisor company: " . $supervisor_company_name;
                    log_this(">>>>>>>>> SNB ERROR UNASSIGNING USER NOT IN SAME COMPANY AS SUPERVISOR :\n\n" . $message . "\n\n\n");
                    $response["message"] = $message;
                    return show_json_error($response);
                }
                //end check if client is belongs to supervisor company

                $count++;

            }
            //end delete client records

            $response["message"] = "Successfully unassigned $count users from supervisor $supervisor_full_names";


        DB::commit();

        return show_json_success($response);

    }

}
