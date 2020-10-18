<?php

namespace App\Services\ShoppingCartItem;

use App\Entities\ShoppingCartItem;
use Illuminate\Support\Facades\DB;

class ShoppingCartItemUpdate
{

    public function updateItem($attributes) {

        $response = [];

        DB::beginTransaction();

        $order_id = "";
        $order_item_id = "";
        $quantity = "";

        if (array_key_exists('order_id_form', $attributes)) {
            $order_id = $attributes['order_id_form'];
        }
        if (array_key_exists('order_item_id_form', $attributes)) {
            $order_item_id = $attributes['order_item_id_form'];
        }
        if (array_key_exists('quantity_form', $attributes)) {
            $quantity = $attributes['quantity_form'];
        }

        // update the cart data
        try {

            updateShoppingCartItemInCart($order_id, $order_item_id, $quantity);

        } catch(\Exception $e) {
            // show error
            $message = "An error occured";
            log_this($message . " - " . $e->getMessage());
            return show_error_response($message);
        }

        // show success
        $message = "Shopping cart successfully updated";
        $response = show_success_response($message);

        DB::commit();

        return $response;

    }

}
