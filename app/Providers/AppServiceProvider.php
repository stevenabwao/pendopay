<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Relations\Relation;
use League\OAuth2\Server\Exception\OAuthServerException;

use App\Entities\SiteSetting;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */

    public function boot()
    {

        Relation::morphMap([
            'image' => 'App\Image'
        ]);

        // avail logged in user to sidebar partial
        view()->composer('layouts.partials.sidebarLeft', function($view){
            $view->with('user', \App\User::getUser());
        });

        // handle dingo api errors - 401 error
        /* app('Dingo\Api\Exception\Handler')->register(function (OAuthServerException $e) {
            return new \Illuminate\Http\Response(['message'=>$e->getMessage(),'status_code'=>$e->httpStatusCode],
                                                    $e->httpStatusCode, $e->getHttpHeaders());
        }); */

        view()->composer('layouts.partials.sidebar', function($view){

            $my_shopping_cart = [];

            $count = 5;
            $status_active = config('constants.status.active');
            $random = true;

            // get featured offers
            $min_products = 1;
            $featured_offers_data = getOffersFront("", "", $count, "", $status_active, "", "", "", "", "", "", "", "", "", "", "", "",
                                         "", "", "", "", "", "", $random, $min_products);

            // get top sales
            $top_sales_data = getOfferProductsFront("", $count, "", $status_active, $random, "", "", "", "", "", "", "", "", "", "");

            // if user is logged in, get user's active shopping cart
            if (isLoggedIn()) {
                $my_shopping_cart = getActiveUserShoppingCart();
            }

            $view->with('featured_offers_data', $featured_offers_data);
            $view->with('top_sales_data', $top_sales_data);
            $view->with('my_shopping_cart', $my_shopping_cart);
        });

        view()->composer('layouts.partials.header', function($view){
            // get constants
            $active_status = config('constants.status.active');
            $clubs_category = config('constants.establishments.club_cat_id');
            $restaurant_category = config('constants.establishments.restaurant_cat_id');

            // get data
            $clubs_data_array = getCompanies("", 8, $clubs_category, $active_status, 1);
            $events_data_array = getOffersFront("", "event", 8, "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", 1, 1);
            $restaurants_data_array = getCompanies("", 8, $restaurant_category, $active_status, 1);

            // pass data
            $view->with('clubs_data', $clubs_data_array);
            $view->with('events_data', $events_data_array);
            $view->with('restaurants_data', $restaurants_data_array);
        });

        //Start Configure Site Settings object
        app()->singleton('site_settings', function(){
            $status_active = config('constants.status.active');
            $site_settings_collections = SiteSetting::where("status_id", $status_active)->get();
            //dd($site_settings_collections);
            $site_settings_array = array();
            foreach($site_settings_collections as $site_settings_collection) {
                $site_settings_array[$site_settings_collection->name] = $site_settings_collection->text_data;
            }
            return $site_settings_array;
        });
        // end Configure Site Settings object

    }

}
