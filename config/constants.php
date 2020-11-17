<?php

    $api_domain_url = "/";
    $api_version_url = "api/";
    $api_path_url = $api_domain_url . $api_version_url;

    // get ips
    $pendo_server_ip = env('PENDO_SERVER_IP');
    $pendo_server_ip_local = env('PENDO_SERVER_IP_LOCAL');
    $app_mode = env('APP_MODE');
    $app_url = env('APP_URL');

    // get paths as per environment
    if ($app_mode == 'test') {
        $remote_pendo_api_url = "http://" . $pendo_server_ip_local . "/api/";
        $remote_base_api_url = "http://" . $pendo_server_ip_local . "/api/";
    } else {
        $remote_pendo_api_url = "http://" . $pendo_server_ip . "/public/api/";
        $remote_base_api_url = "http://" . $pendo_server_ip . "/public/api/";
    }

    return [

        'barddy_company' => [
            'id' => env('APP_BARDDY_COMPANY_ID'),
            'system_user_id' => '-99',
            'system_user_name' => 'System',
        ],
        'images' => [
            'no_image_full' => "images/no_image.jpg",
            'no_image_thumb' => "images/no_image.jpg",
            // 'no_image_thumb_400' => "images/no_image.jpg",
            'no_image_thumb_400' => "images/no_image_sq.jpg",
        ],
        'imagetabletypes' => [
            'offer_image' => "offerimage",
            'club_image' => "club",
        ],
        'establishments' => [
            'club_cat_id' => 2,
            'restaurant_cat_id' => 3,
            'shop_cat_id' => 4,
            'organization_cat_id' => 4,
            'club_cat_text' => 'clubs',
            'restaurant_cat_text' => 'restaurants',
            'shop_cat_text' => 'shops',
            'organization_cat_text' => 'organizations',
            'single_offer_text' => 'offer',
            'offer_cat_text' => 'offers',
        ],
        'pagetitles' => [
            'my_shopping_cart_text' => 'My Shopping Cart',
            'review_order_text' => 'Review Order',
        ],
        'mediatypes' => [
            'sms' => 'sms',
            'email' => 'email',
        ],
        'transactionroles' => [
            'buyer' => 'buyer',
            'seller' => 'seller',
            'select_buyer_text' => 'Please Select Buyer',
            'select_seller_text' => 'Please Select Seller',
            'select_buyer_seller_text' => 'Please Select Buyer/ Seller',
            'wait_seller_accept_text' => 'Please wait for seller to accept',
            'wait_buyer_accept_text' => 'Please wait for buyer to accept',
            'accept_to_proceed_text' => 'Please accept request to proceed',
        ],
        'sitefunctions' => [
            'registration' => 'registration',
            'passwordreset' => 'passwordreset',
            'transactionrequest' => 'transactionrequest',
            'transactionrequest_noaccount' => 'transactionrequest_noaccount',
        ],
        'sitesections' => [
            'transactionrequest' => 'transactionrequest',
        ],
        'email' => [
            'subject' =>    [
                                'passwordreset' => 'Reset Password',
                                'passwordreset' => 'passwordreset',
                            ],
        ],

        'routes' => [
            'get_users_url' => $api_path_url . 'users/index',
            'create_user_url' => $api_path_url . 'users/create',
            'create_message_url' => $api_path_url . 'smsoutbox/create',
            'fetch_savings_deposit_accounts_url' => $api_path_url . 'savings-deposit-accounts',
            'product_category_change_url' => $api_path_url . 'products',
            'product_change_url' => $api_path_url . 'products',
            'company_product_verify_url' => $api_path_url . 'companyproducts/verify',
        ],

        'settings' => [
            'app_mode' => env('APP_MODE'),
            'app_short_name' => env('APP_SHORT_NAME'),
            'pendoapi_app_name' => env('PENDOAPI_APP_NAME'),
            'app_location' => env('APP_LOCATION'),
            'app_send_sms' => env('APP_SEND_SMS'),
        ],

        'site_category' => [
            'projects' => "1",
            'clubs' => "2",
            'industries' => "9",
            'news' => "3",
            'home_slider' => "4",
            'category_photos' => "5",
            'about_us' => "6",
            'core_values_icons' => "7",
            'main_pillars' => "8",
            'mgt_team' => "12",
            'board_of_directors' => "13",
        ],

        'product_category' => [
            'beer' => "1",
            'brandy' => "3",
            'gin' => "4",
            'cognac' => "7",
            'rum' => "8",
            'vodka' => "10",
            'whisky' => "11",
            'cider' => "12",
            'wine' => "13",
            'liqueur' => "14",
        ],

        'product_min_qty' => [
            'beer' => "3",
        ],

        'payment_modes' => [
            'mpesa' => "mpesa",
        ],

        'barddy_settings' => [
            'helpline' => env('SNB_HELPLINE'),
            'website' => env('SNB_WEBSITE'),
            'company_name' => env('SNB_COMPANY_NAME'),
        ],

        'account_settings' => [
            'default_branch_cd' => '01',
            'default_company_id' => '622',
            'default_account_type_cd' => '30',
            'default_group_cd' => '01',
            'savings_account_product_id' => '3',
            'loan_account_product_id' => '2',
            'registration_account_product_id' => '7',
            'deposit_account_product_id' => '4',
            'loan_account_product_id' => '2',
            'mobile_loan_product_id' => '6',
            'shares_account_product_id' => '13',
            'transaction_account_type_id' => '31',
        ],

        'membership_age_limits' => [
            'one_month_limit' => "one_month_limit",
            'one_to_three_month_limit' => "one_to_three_month_limit",
            'three_to_six_month_limit' => "three_to_six_month_limit",
            'above_six_month_limit' => "above_six_month_limit",
        ],

        'reminder_category' => [
            'sms' => '1',
            'email' => '2',
        ],

        'reminder_type_sections' => [
            'overdue_loans' => "1",
            'active_loans' => "2",
            'almost_expiring_loans' => "3",
        ],

        'site_text' => [
            'no_photo_text' => "No Photo",
            'almost_expiring_loans' => "almost_expiring_loans",
        ],

        'reminder_message_types' => [
            'overdue_loans' => "overdue_loans",
            'almost_expiring_loans' => "almost_expiring_loans",
        ],

        'pendoapi_passport' => [
            'token_url' => $remote_pendo_api_url . 'login',
            'user_url' => $api_path_url . 'user',
            'username' => env('PENDOAPI_OAUTH_USERNAME'),
            'password' => env('PENDOAPI_OAUTH_PASSWORD'),
        ],

        'pendoapi_urls' => [
            'companies_url' => $remote_pendo_api_url . 'companies',
        ],

        'bulk_sms' => [
            'send_sms_url' => $remote_pendo_api_url . "sms/sendSms",
            'get_sms_outbox_url' => $remote_pendo_api_url . "sms/outbox",
        ],

        'mpesa_paybills' => [
            'get_paybills_url' => $remote_pendo_api_url . "mpesapaybills",
            'create_paybills_url' => $remote_pendo_api_url . "mpesapaybills",
        ],
        'mpesa_shortcodes' => [
            'get_shortcodes_url' => $remote_pendo_api_url . "mpesashortcodes",
        ],
        'mpesa' => [
            //'getpayments_url' => $remote_base_api_url . 'mpesa/getpayments',
            'getpayments_url' => $remote_pendo_api_url . 'mpesa/getpayments',
            'mpesab2c_url' => $remote_pendo_api_url . 'mpesab2c',
            'mpesab2c_balance_url' => $remote_pendo_api_url . 'mpesab2c/checkbalance',
            'checktransid' => $remote_pendo_api_url . 'mpesa/checktransid',
            'stkpush_url' => $remote_pendo_api_url . 'mpesa/checkout',
        ],

        'site' => [
            'url' => env('APP_URL'),
        ],

        'email' => [
            'from_name' => env('MAIL_FROM_NAME'),
            'from_mail' => env('MAIL_FROM_ADDRESS'),
        ],

        'sms_types' => [
            'registration_sms' => "1",
            'recommendation_sms' => "2",
            'resent_registration_sms' => "3",
            'forgot_password_sms' => "4",
            'confirmation_sms' => "5",
            'company_sms' => "6",
            'reminder_sms' => "7",
            'password_reset_sms' => "8",
        ],

        'gl_account_types' => [
            'registration' => "1",
            'mobile_loans_principal' => "4",
            'account_charges' => "7",
            'client_deposits' => "12",
            'mobile_loans_interest' => "8",
            'mobile_loans_interest_income' => "13",
            'mobile_loans_penalty' => "3",
            'shares' => "14",
            'club_income' => "20",
            'club_refunds' => "21",
            'club_withdrawals' => "22",
            'club_expenses' => "23",
        ],

        'account_type_text' => [
            'deposit_account' => "deposit_account",
            'loan_account' => "loan_account",
            'shares_account' => "shares_account",
        ],

        'establishment_category' => [
            'admin' => "1",
            'day_night_club' => "2",
            'restaurant' => "3",
            'drinks_shop' => "4",
            'organization' => "5",
        ],

        'offer_frequency' => [
            'once' => "once",
            'daily' => "recurring-daily",
            'weekly' => "recurring-weekly",
            'monthly' => "recurring-monthly",
            'yearly' => "recurring-yearly",
        ],

        'user_contribution_criteria' => [
            'savings' => "1",
            'savings_shares' => "2",
            'savings_registration' => "3",
            'savings_registration_shares' => "4",
            'initial_loan_limit' => "5",
        ],

        'oauth' => [
            'token_url' => $remote_base_api_url . "login",
            'username' => env('OAUTH_USERNAME'),
            'password' => env('OAUTH_PASSWORD'),
            'client_id' => env('OAUTH_CLIENT_ID'),
            'client_secret' => env('OAUTH_CLIENT_SECRET')
        ],

        'status' => [
            'active' => "1",
            'disabled' => "2",
            'suspended' => "3",
            'expired' => "4",
            'completed' => "5",
            'pending' => "6",
            'awaitingdelivery' => "7",
            'confirmed' => "8",
            'notconfirmed' => "9",
            'paid' => "10",
            'notpaid' => "11",
            'deleted' => "12",
            'orderplaced' => "13",
            'redeemed' => "14",
            'cancelled' => "15",
            'waiting' => "16",
            'deactivated' => "17",
            'sent' => "18",
            'incompleted' => "19",
            'inactive' => "99",
        ],

        'status_text' => [
            'active' => "Active",
            'disabled' => "Disabled",
            'suspended' => "Suspended",
            'expired' => "Expired",
            'completed' => "Completed",
            'pending' => "Pending",
            'awaitingdelivery' => "Awaiting Delivery",
            'confirmed' => "Confirmed",
            'notconfirmed' => "Not Confirmed",
            'paid' => "Paid",
            'notpaid' => "Not Paid",
            'deleted' => "Deleted",
            'orderplaced' => "Order Placed",
            'redeemed' => "Redeemed",
            'cancelled' => "Cancelled",
            'waiting' => "Waiting",
            'deactivated' => "Deactivated",
            'sent' => "Sent",
            'incompleted' => "Incompleted",
            'inactive' => "Inactive",
        ],

        'message_text' => [
            '200' => "Request OK",
            '201' => "Successfully Created",
            '401' => "Unauthenticated",
            '403' => "Unauthorized",
            '404' => "Record not found",
            '422' => "Unprocessable Entity",
            '500' => "Server Error",
        ],



        'duration' => [
            'day' => "1",
            'week' => "2",
            'month' => "3",
            'year' => "4",
        ],

        'error_messages' => [
            'exceeded_max_loan_limit' => "Your loan application has exceeded the allowed loan limit",
            'disabled' => "2",
            'suspended' => "3",
            'expired' => "4",
            'pending' => "5",
            'confirmed' => "6",
            'cancelled' => "7",
            'sent' => "8",
            'declined' => "9",
            'approved' => "10",
            'inactive' => "99",
        ],

        'status_codes' => [
            'error_codes' => [
                'common' => [
                    'record_already_procesed' => "540",
                    '541' => "541",
                ]
            ]
        ]

    ];
