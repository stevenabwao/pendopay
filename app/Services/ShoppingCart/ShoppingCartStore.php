<?php

namespace App\Services\ShoppingCart;

use App\Entities\ShoppingCart;
use Illuminate\Support\Facades\DB;

class ShoppingCartStore
{

    public function createItem($attributes) {
        // dd($attributes);

        $response = [];

        DB::beginTransaction();

        $offer_product_id = "";
        $offer_id = "";
        $product_quantity = "";

        if (array_key_exists('offer_product_id', $attributes)) {
            $offer_product_id = $attributes['offer_product_id'];
        }
        if (array_key_exists('offer_id', $attributes)) {
            $offer_id = $attributes['offer_id'];
        }
        if (array_key_exists('product_quantity_form', $attributes)) {
            $product_quantity = $attributes['product_quantity_form'];
        }

        // check if user has an active shopping cart
        $shopping_cart = getActiveUserShoppingCart();

        // check whether an active shopping cart exists for this user
        if ($shopping_cart) {

            // get shopping cart offer name
            $offer_name = $shopping_cart->offer->name;
            $company_name = $shopping_cart->company->name;

            // use existing shopping cart
            // check if shopping cart has items from same establishment
            // if items are not from same establishment, show error
            if (!cartProductFromSameOffer($offer_product_id)) {
                // show error
                $message = "Shopping cart must only contain products from the same offer {{$offer_name}} from establishment {{$company_name}}";
                return show_error_response($message);
            }

            // add product to cart
            try {

                addProductToCart($offer_product_id, $product_quantity);

            } catch(\Exception $e) {
                // show error
                $message = "An error occured";
                log_this($message . " - " . $e->getMessage());
                return show_error_response($message);
            }

        } else {

            // create new shopping cart
            // add product to cart
            try {

                addProductToCart($offer_product_id, $product_quantity);

            } catch(\Exception $e) {
                // show error
                $message = "An error occured";
                log_this($message . " - " . $e->getMessage());
                return show_error_response($message);
            }

        }

        // show success
        $message = "Product successfully added to shopping cart";
        $response = show_success_response($message);

        DB::commit();

        return $response;

    }

}
