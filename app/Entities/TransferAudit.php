<?php

namespace App\Entities;

use App\BaseModel;
use App\Entities\Company;
use App\Entities\CompanyUser;
use App\Entities\Status;
use App\Entities\Transfer;
use App\User;

class TransferAudit extends BaseModel
{

    /**
     * The attributes that are mass assignable
    **/
    protected $fillable = [
         'parent_id', 'source_account_type', 'source_account_id', 'source_account_name',
         'source_company_user_id', 'destination_company_user_id', 'source_phone', 'destination_phone',
         'destination_account_type', 'destination_account_id', 'destination_account_name',
         'amount', 'comments', 'status_id', 'company_id', 'source_account_no', 'destination_account_no',
         'created_at', 'created_by', 'updated_at', 'updated_by'
    ];

    public function transfer()
    {
        return $this->belongsTo(Transfer::class, 'parent_id','id');
    }

    public function sourcecompanyuser()
    {
        return $this->belongsTo(CompanyUser::class, 'source_company_user_id', 'id');
    }

    public function destinationcompanyuser()
    {
        return $this->belongsTo(CompanyUser::class, 'destination_company_user_id', 'id');
    }

    public function transferaudits()
    {
        return $this->belongsTo(LoanApplicationAudit::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
        //class, foreign key, local key
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }

    /**
     * @param array $attributes
     * @return \Illuminate\Database\Eloquent\Model
     */
    public static function create(array $attributes = [])
    {

        $attributes['parent_id'] = $attributes['id'];

        // remove id and updated_by fields from array,
        // id will be auto populated (autoincrement field)
        unset($attributes['id']);

        $model = static::query()->create($attributes);

        return $model;

    }

}
