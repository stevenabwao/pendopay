<?php

namespace App\Entities;

use App\BaseModel;
use App\Entities\Status;
use App\Entities\Company;
use App\Entities\GlAccount;
use App\User;

class GlAccountHistory extends BaseModel
{

    protected $table = "gl_account_history";

    /**
     * The attributes that are mass assignable
    **/
    protected $fillable = [
         'id', 'gl_account_no', 'event_id', 'amount', 'currency_id', 'payment_id',
         'dr_cr_ind', 'channel_id', 'tran_ref_txt', 'tran_desc', 'stmnt_bal', 'company_id',
         'status_id', 'created_by', 'updated_by', 'created_by_name', 'updated_by_name'
    ];

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function glaccount()
    {
        return $this->belongsTo(GlAccount::class, 'gl_account_no', 'gl_account_no');
        //class, foreign key, local key
    }

    public function payment()
    {
        return $this->belongsTo(Payment::class);
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

        $model = static::query()->create($attributes);

        return $model;

    }

    /**
     * @param array $attributes
     * @return \Illuminate\Database\Eloquent\Model
     */
    public static function updatedata($id, array $attributes = [])
    {

        // data
        $item = static::query()->findOrFail($id);

        $model = $item->update($attributes);

        return $model;

    }


}
