<?php

namespace App\Entities;
use App\Entities\Account;
use App\Entities\LoanAccount;
use App\Entities\LoanApplication;
use App\Entities\Loan;
use App\Entities\Product;
use App\Entities\ProductAudit;
use App\Entities\Offer;
use App\Entities\OfferProduct;
use App\Entities\OfferProductAudit;
use App\Entities\ShoppingCart;
use App\Entities\ShoppingCartAudit;
use App\Entities\Order;
use App\Entities\Status;
use App\Entities\MpesaB2CTopupLevel;
use App\Entities\CompanyProduct;
use App\Entities\CompanyProductAudit;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{

    protected $fillable = [
        'id', 'name', 'initials', 'status_id', 'created_at', 'created_by', 'updated_at', 'updated_by'
    ];

    /*one to many relationship*/
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function productaudits()
    {
        return $this->hasMany(ProductAudit::class);
    }

    public function offers()
    {
        return $this->hasMany(Offer::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function shoppingcarts()
    {
        return $this->hasMany(ShoppingCart::class);
    }

    public function shoppingcartaudits()
    {
        return $this->hasMany(ShoppingCartAudit::class);
    }

    public function accounts()
    {
        return $this->hasMany(Account::class);
    }

    public function depositaccounts()
    {
        return $this->hasMany(DepositkAccount::class);
    }

    public function glaccountssummary()
    {
        return $this->hasMany(GlAccountSummary::class);
    }

    public function loanaccounts()
    {
        return $this->hasMany(LoanAccount::class);
    }

    public function loanapplications()
    {
        return $this->hasMany(LoanApplication::class);
    }

    public function loans()
    {
        return $this->hasMany(Loan::class);
    }

    public function mpesab2ctopuplevels()
    {
        return $this->hasMany(MpesaB2CTopupLevel::class);
    }

    public function companyproducts()
    {
        return $this->hasMany(CompanyProduct::class);
    }

    public function companyproductaudits()
    {
        return $this->hasMany(CompanyProductAudit::class);
    }

    public function offerproducts()
    {
        return $this->hasMany(OfferProduct::class);
    }

    public function offerproductaudits()
    {
        return $this->hasMany(OfferProductAudit::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }

    //start convert dates to local dates
    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->timezone(getLocalTimezone());
    }

    public function getUpdatedAtAttribute($value)
    {
        return Carbon::parse($value)->timezone(getLocalTimezone());
    }
    //end convert dates to local dates


    /**
     * @param array $attributes
     * @return \Illuminate\Database\Eloquent\Model
     */
    public static function create(array $attributes = [])
    {

        $user_id = auth()->user()->id;

        $attributes['created_by'] = $user_id;
        $attributes['updated_by'] = $user_id;

        $model = static::query()->create($attributes);

        return $model;

    }

    /**
     * @param array $attributes
     * @return \Illuminate\Database\Eloquent\Model
     */
    public static function updatedata($id, array $attributes = [])
    {

        $user_id = auth()->user()->id;

        $attributes['updated_by'] = $user_id;

        //product data
        $product = static::query()->findOrFail($id);

        //do any extra processing here

        $model = $product->update($attributes);

        return $model;

    }


}
