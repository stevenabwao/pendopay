<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Resources\Json\ResourceCollection;

class UserCollection extends ResourceCollection
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'dob' => $this->dob,
            'gender' => $this->gender,
            'gender_name' => $this->gender_name,
            'status_id' => $this->status_id,
            'status' => $this->status->name,
            'company_id' => $this->company_id,
            'company' => $this->company_name,
            'active' => $this->active,
            'county_id' => $this->county_id,
            'county_name' => $this->county_name,
            'city_id' => $this->city_id,
            'constituency_id' => $this->constituency_id,
            'constituency_name' => $this->constituency_name,
            'ward_id' => $this->ward_id,
            'phone' => getDatabasePhoneNumber($this->phone, $this->phone_country),
            'phone_country' => $this->phone_country,
            'src_ip' => $this->src_ip,
            'created_by' => $this->created_by,
            'created_by_name' => $this->created_by_name,
            'updated_by' => $this->updated_by,
            'updated_by_name' => $this->updated_by_name,
            'user_type' => $this->user_type,
            'is_company_user' => $this->is_company_user,
            'id_no' => $this->id_no,
            'is_company_user' => $this->is_company_user,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
