<?php

use App\Entities\Company;
use App\Entities\BranchGroup;
use App\Entities\BranchMember;
use App\Entities\GroupMember;
use App\Entities\CompanyProduct;
use App\Entities\MpesaPaybill;
use App\Entities\CompanyUser;
use App\Entities\Offer;
use App\Entities\OfferProduct;
use App\Entities\Till;
use App\Entities\Transaction;
use App\Permission;
use App\Role;
use App\User;

// Home
Breadcrumbs::register('home', function($breadcrumbs)
{
    $breadcrumbs->push('Home', route('home'));
});


/******** mpesab2cbalances ROUTES ********/

// Home > mpesab2cbalances
Breadcrumbs::register('mpesab2cbalances', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Mpesa B2C Balances', route('mpesab2cbalances.index'));
});

// Home > mpesab2cbalances > Show balance
Breadcrumbs::register('mpesab2cbalances.show', function($breadcrumbs, $id)
{
    $breadcrumbs->parent('mpesab2cbalances');
    $breadcrumbs->push('Showing Mpesa B2C Balance', route('mpesab2cbalances.show', $id));
});

/********  mpesab2cbalances ROUTES ********/


/******** mpesab2ctrans ROUTES ********/

// Home > mpesab2ctrans
Breadcrumbs::register('mpesab2ctrans', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Mpesa B2C Transactions', route('mpesab2ctrans.index'));
});

// Home > mpesab2ctrans > Show trans
Breadcrumbs::register('mpesab2ctrans.show', function($breadcrumbs, $id)
{
    $breadcrumbs->parent('mpesab2ctrans');
    $breadcrumbs->push('Showing Mpesa B2C Transaction', route('mpesab2ctrans.show', $id));
});

/********  mpesab2ctrans ROUTES ********/


/******** SMS OUTBOX ROUTES ********/

// Home > SMS outbox
Breadcrumbs::register('smsoutbox', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Sms Outbox', route('smsoutbox.index'));
});

// Home > SMS outbox > Create New SMS
Breadcrumbs::register('smsoutbox.create', function($breadcrumbs)
{
    $breadcrumbs->parent('smsoutbox');
    $breadcrumbs->push('Create New SMS', route('smsoutbox.create'));
});

// Home > SMS outbox > Show SMS
Breadcrumbs::register('smsoutbox.show', function($breadcrumbs, $id)
{
    $breadcrumbs->parent('smsoutbox');
    $breadcrumbs->push($id, route('smsoutbox.show', $id));
});

/******** SMS OUTBOX ROUTES ********/


/******** TRANSFERS ROUTES ********/

// Home > Transfers
Breadcrumbs::register('transfers', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Transfers', route('transfers.index'));
});

// Home > Transfers > Create New Transfer
Breadcrumbs::register('transfers.create', function($breadcrumbs)
{
    $breadcrumbs->parent('transfers');
    $breadcrumbs->push('Create New Transfer', route('transfers.create'));
});

Breadcrumbs::register('transfers.create-step2', function($breadcrumbs)
{
    $breadcrumbs->parent('transfers.create');
    $breadcrumbs->push('Create Funds Transfer - Step 2', route('transfers.create_step2'));
});

Breadcrumbs::register('transfers.create-step3', function($breadcrumbs)
{
    $breadcrumbs->parent('transfers.create-step2');
    $breadcrumbs->push('Create Funds Transfer - Step 3', route('transfers.create_step3'));
});

// Home > Transfers > Show Transfer
Breadcrumbs::register('transfers.show', function($breadcrumbs, $id)
{
    $breadcrumbs->parent('transfers');
    $breadcrumbs->push($id, route('transfers.show', $id));
});

// Home > Transfers > Edit Transfer
Breadcrumbs::register('transfers.edit', function($breadcrumbs, $id)
{
    $breadcrumbs->parent('transfers');
    $breadcrumbs->push("Edit group - " . $id, route('transfers.edit', $id));
});
/******** END TRANSFERS ROUTES ********/


/******** COMPANIES ROUTES ********/

// Home > Companies
Breadcrumbs::register('companies', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Companies', route('companies.index'));
});

// Home > Companies > Create New Company
Breadcrumbs::register('companies.create', function($breadcrumbs)
{
    $breadcrumbs->parent('companies');
    $breadcrumbs->push('Create New Company', route('companies.create'));
});

// Home > Companies > Show Company
Breadcrumbs::register('companies.show', function($breadcrumbs, $id)
{
    $company = Company::findOrFail($id);
    $breadcrumbs->parent('companies');
    $breadcrumbs->push($company->name, route('companies.show', $company->id));
});

// Home > Companies > Edit Company
Breadcrumbs::register('companies.edit', function($breadcrumbs, $id)
{
    $company = Company::findOrFail($id);
    $breadcrumbs->parent('companies');
    $breadcrumbs->push("Edit company - " . $company->name, route('companies.edit', $company->id));
});

/******** END COMPANIES ROUTES ********/


/******** MY TRANSACTIONS ROUTES ********/

// Home > My Transactions
Breadcrumbs::register('my-transactions.index', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('My Transactions', route('my-transactions.index'));
});

// Home > My Transactions > Create New Transaction
Breadcrumbs::register('my-transactions.create', function($breadcrumbs)
{
    $breadcrumbs->parent('my-transactions.index');
    $breadcrumbs->push('Create New Transaction', route('my-transactions.create'));
});

// Home > My Transactions > Show Transaction
Breadcrumbs::register('my-transactions.show', function($breadcrumbs, $id)
{
    $transaction = Transaction::findOrFail($id);
    $breadcrumbs->parent('my-transactions.index');
    $breadcrumbs->push($transaction->title, route('my-transactions.show', $transaction->id));
});

// Home > My Transactions > Edit Transaction
Breadcrumbs::register('my-transactions.edit', function($breadcrumbs, $id)
{
    $transaction = Transaction::findOrFail($id);
    $breadcrumbs->parent('my-transactions.index');
    $breadcrumbs->push("Edit transaction - " . $transaction->name, route('my-transactions.edit', $transaction->id));
});

/******** END MY TRANSACTIONS ROUTES ********/

/********PAYMENTS ROUTES ********/
// Home > My Payments
Breadcrumbs::register('my-payments.index', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('My Payments', route('my-payments.index'));
   
});
// Home > My Payments>New Payment
Breadcrumbs::register('my-payments.create', function($breadcrumbs)
{
    $breadcrumbs->parent('my-payments.index');
    $breadcrumbs->push('New Payment', route('my-payments.create'));
});
/*********END OF PAYMENTS ROUTES ********/
/*********DEPOSITS  ROUTES */
Breadcrumbs::register('my-account.deposit.create', function($breadcrumbs)

{   
    $breadcrumbs->parent('home');
    $breadcrumbs->push('My Account /New Deposit', route('my-account.deposit.create'));
});

/*********TRANSFER  ROUTES */
Breadcrumbs::register('my-account.transferfund.create', function($breadcrumbs)

{   
    $breadcrumbs->parent('home');
    $breadcrumbs->push('My Account /New Transfer', route('my-account.transferfund.create'));
});

/******** ADMIN OFFERS ROUTES ********/

// Home > admin > offers
Breadcrumbs::register('admin.offers', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Offers', route('admin.offers.index'));
});

// Home > admin > offers > create
Breadcrumbs::register('admin.offers.create', function($breadcrumbs)
{
    $breadcrumbs->parent('admin.offers');
    $breadcrumbs->push('Create Offer', route('admin.offers.create'));
});

// Home > admin > offers > show
Breadcrumbs::register('admin.offers.show', function($breadcrumbs, $id)
{
    $offer = Offer::findOrFail($id);
    $breadcrumbs->parent('admin.offers');
    $breadcrumbs->push($offer->name, route('admin.offers.show', $offer->id));
});

// Home > admin > offers > Add Products create
Breadcrumbs::register('admin.offers.add-products.create', function($breadcrumbs, $id)
{
    $breadcrumbs->parent('admin.offers.show', $id);
    $breadcrumbs->push('Add Product To Offer', route('admin.offers.add-products.create', $id));
});

// Home > admin > offers > Edit offer
Breadcrumbs::register('admin.offers.edit', function($breadcrumbs, $id)
{
    $offer = Offer::findOrFail($id);
    $breadcrumbs->parent('admin.offers');
    $breadcrumbs->push("Edit offer - " . $offer->name, route('admin.offers.edit', $offer->id));
});
/******** END ADMIN OFFERS ROUTES ********/


/******** FRONTEND OFFERS ROUTES ********/

// Home > clubs > club permalink > offers
Breadcrumbs::register('offers.showClubOffer', function($breadcrumbs, $company_link, $offer_link)
{
    $breadcrumbs->parent('clubs.show', $company_link);
    $breadcrumbs->push('Club Offer', route('offers.showClubOffer', [$company_link, $offer_link]));
});
/******** END FRONTEND OFFERS ROUTES ********/


/******** FRONTEND SHOPPING CART ROUTES ********/
// Home > My Shopping Cart
Breadcrumbs::register('my-shopping-cart', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('My Shopping Cart', route('my-shopping-cart'));
});

// Home > Review Order
Breadcrumbs::register('review-order', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Review Order', route('review-order'));
});

// Home > Review Order > Make Payment
Breadcrumbs::register('make-payment', function($breadcrumbs, $id)
{
    $breadcrumbs->parent('review-order');
    $breadcrumbs->push('Make payment - Order ID ' . $id, route('make-payment', $id));
});

// Home > Payment Status
Breadcrumbs::register('payment-status', function($breadcrumbs, $id)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Payment status - Order ID ' . $id, route('payment-status', $id));
});
/******** END FRONTEND SHOPPING CART ROUTES ********/


/******** ADMIN OFFERPRODUCTS ROUTES ********/

// Home > admin > offerproducts
Breadcrumbs::register('admin.offerproducts', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Offer Products', route('admin.offerproducts.index'));
});

// Home > admin > offerproducts > create
Breadcrumbs::register('admin.offerproducts.create', function($breadcrumbs)
{
    $breadcrumbs->parent('admin.offerproducts');
    $breadcrumbs->push('Create Offer Product', route('admin.offerproducts.create'));
});

// Home > admin > offerproducts > show
Breadcrumbs::register('admin.offerproducts.show', function($breadcrumbs, $id)
{
    $offerproduct = OfferProduct::findOrFail($id);
    $breadcrumbs->parent('admin.offerproducts');
    $breadcrumbs->push($offerproduct->companyproduct->product->name, route('admin.offerproducts.show', $offerproduct->id));
});

// Home > admin > offerproducts > Edit offerproduct
Breadcrumbs::register('admin.offerproducts.edit', function($breadcrumbs, $id)
{
    $offerproduct = OfferProduct::findOrFail($id);
    $breadcrumbs->parent('admin.offerproducts');
    $breadcrumbs->push("Edit Offer Product - " . $offerproduct->companyproduct->product->name, route('admin.offerproducts.edit', $offerproduct->id));
});
/******** END ADMIN OFFERPRODUCTS ROUTES ********/


/******** ADMIN TILLS ROUTES ********/
// Home > admin > tills
Breadcrumbs::register('admin.tills', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Tills', route('admin.tills.index'));
});

// Home > admin > tills > create
Breadcrumbs::register('admin.tills.create', function($breadcrumbs)
{
    $breadcrumbs->parent('admin.tills');
    $breadcrumbs->push('Create Till', route('admin.tills.create'));
});

// Home > admin > tills > show
Breadcrumbs::register('admin.tills.show', function($breadcrumbs, $id)
{
    $till = Till::findOrFail($id);
    $breadcrumbs->parent('admin.tills');
    $breadcrumbs->push($till->till_number, route('admin.tills.show', $till->id));
});

// Home > admin > tills > Edit till
Breadcrumbs::register('admin.tills.edit', function($breadcrumbs, $id)
{
    $till = Till::findOrFail($id);
    $breadcrumbs->parent('admin.tills');
    $breadcrumbs->push("Edit till - " . $till->till_number, route('admin.tills.edit', $till->id));
});

// confirm till create
Breadcrumbs::register('admin.tills.confirm-till-create', function($breadcrumbs, $id)
{
    $till = Till::findOrFail($id);
    $breadcrumbs->parent('admin.tills');
    $breadcrumbs->push('Confirm Till - ' . $till->id, route('admin.tills.confirm-till-create', $till->id));
});
/******** END ADMIN TILLS ROUTES ********/


/******** CLUBS ROUTES ********/
// Home > admin > clubs
Breadcrumbs::register('clubs', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('clubs', route('clubs'));
});

// Home > admin > clubs > show
Breadcrumbs::register('clubs.show', function($breadcrumbs, $id)
{
    $club = Company::findOrFail($id);
    $breadcrumbs->parent('clubs');
    $breadcrumbs->push($club->name, route('clubs.show', $club->id));
});
/******** END CLUBS ROUTES ********/


/******** ADMIN ESTABLISHMENTS ROUTES ********/
// Home > admin > establishments
Breadcrumbs::register('admin.establishments', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Establishments', route('admin.establishments.index'));
});

// Home > admin > establishments > create
Breadcrumbs::register('admin.establishments.create', function($breadcrumbs)
{
    $breadcrumbs->parent('admin.establishments');
    $breadcrumbs->push("Create establishment ", route('admin.establishments.create'));
});

// Home > admin > establishments > show
Breadcrumbs::register('admin.establishments.show', function($breadcrumbs, $id)
{
    $establishment = Company::findOrFail($id);
    $breadcrumbs->parent('admin.establishments');
    $breadcrumbs->push($establishment->name, route('admin.establishments.show', $establishment->id));
});

// Home > admin > establishments > Edit establishment
Breadcrumbs::register('admin.establishments.edit', function($breadcrumbs, $id)
{
    $establishment = Company::findOrFail($id);
    $breadcrumbs->parent('admin.establishments');
    $breadcrumbs->push("Edit establishment - " . $establishment->name, route('admin.establishments.edit', $establishment->id));
});
/******** END ADMIN ESTABLISHMENTS ROUTES ********/


/******** ADMIN ORDERS ROUTES ********/
// Home > admin > orders
Breadcrumbs::register('admin.orders', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Orders', route('admin.orders.index'));
});

// Home > admin > orders > create
Breadcrumbs::register('admin.orders.create', function($breadcrumbs)
{
    $breadcrumbs->parent('admin.orders');
    $breadcrumbs->push("Create order ", route('admin.orders.create'));
});

// Home > admin > orders > show
Breadcrumbs::register('admin.orders.show', function($breadcrumbs, $id)
{
    $order = Company::findOrFail($id);
    $breadcrumbs->parent('admin.orders');
    $breadcrumbs->push($order->name, route('admin.orders.show', $order->id));
});

// Home > admin > orders > Edit order
Breadcrumbs::register('admin.orders.edit', function($breadcrumbs, $id)
{
    $order = Company::findOrFail($id);
    $breadcrumbs->parent('admin.orders');
    $breadcrumbs->push("Edit order - " . $order->name, route('admin.orders.edit', $order->id));
});
/******** END ADMIN ORDERS ROUTES ********/


/******** ADMIN Establishment PRODUCTS ROUTES ********/

// Home > admin > Establishmentproducts
Breadcrumbs::register('admin.companyproducts', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Establishment Products', route('admin.companyproducts.index'));
});

// Home > branchgroups > Create New Company Branch
Breadcrumbs::register('admin.companyproducts.create', function($breadcrumbs)
{
    $breadcrumbs->parent('admin.companyproducts');
    $breadcrumbs->push('Create New Company Product', route('admin.companyproducts.create'));
});

// Home > admin > Establishmentproducts > show
Breadcrumbs::register('admin.companyproducts.show', function($breadcrumbs, $id)
{
    $companyproduct = CompanyProduct::findOrFail($id);
    $breadcrumbs->parent('admin.companyproducts');
    $breadcrumbs->push($companyproduct->product->name, route('admin.companyproducts.show', $companyproduct->id));
});

// Home > admin > Establishmentproducts > Edit companyproduct
Breadcrumbs::register('admin.companyproducts.edit', function($breadcrumbs, $id)
{
    $companyproduct = CompanyProduct::findOrFail($id);
    $breadcrumbs->parent('admin.companyproducts');
    $breadcrumbs->push("Edit Establishment Product - " . $companyproduct->product->name, route('admin.companyproducts.edit', $companyproduct->id));
});
/******** END ADMIN Establishment PRODUCTS ROUTES ********/


/******** COMPANY BRANCH Groups ROUTES ********/

// Home > Companybranches
Breadcrumbs::register('branchgroups', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Company Branch Groups', route('branchgroups.index'));
});

// Home > branchgroups > Create New Company Branch
Breadcrumbs::register('branchgroups.create', function($breadcrumbs)
{
    $breadcrumbs->parent('branchgroups');
    $breadcrumbs->push('Create New Branch Group', route('branchgroups.create'));
});

// Home > branchgroups > Show Company Branch
Breadcrumbs::register('branchgroups.show', function($breadcrumbs, $id)
{
    $branchgroup = BranchGroup::findOrFail($id);
    $breadcrumbs->parent('branchgroups');
    $breadcrumbs->push($branchgroup->name, route('branchgroups.show', $branchgroup->id));
});

// Home > branchgroups > Edit Company Branch
Breadcrumbs::register('branchgroups.edit', function($breadcrumbs, $id)
{
    $branchgroup = BranchGroup::findOrFail($id);
    $breadcrumbs->parent('branchgroups');
    $breadcrumbs->push("Edit Branch Group - " . $branchgroup->name, route('branchgroups.edit', $branchgroup->id));
});

/******** END COMPANY BRANCH Groups ROUTES ********/


/******** COMPANY BRANCH Group Members ROUTES ********/

// Home > groupmembers
Breadcrumbs::register('groupmembers', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Group Members', route('groupmembers.index'));
});

// Home > groupmembers > Create New  Group Member
Breadcrumbs::register('groupmembers.create-step1', function($breadcrumbs)
{
    $breadcrumbs->parent('groupmembers');
    $breadcrumbs->push('Add Group Member - Step 1', route('groupmembers.create-step1'));
});

Breadcrumbs::register('groupmembers.create-step2', function($breadcrumbs)
{
    $breadcrumbs->parent('groupmembers.create-step1');
    $breadcrumbs->push('Add Group Member - Step 2', route('groupmembers.create-step2'));
});

// Home > groupmembers > Show  Group Member
Breadcrumbs::register('groupmembers.show', function($breadcrumbs, $id)
{
    $groupmember = GroupMember::findOrFail($id);
    $groupmembername = "";
    if($groupmember->branchmember) {
      $groupmembername = $groupmember->branchmember->companyuser->user->first_name;
      $groupmembername .= " " . $groupmember->branchmember->companyuser->user->last_name;
    }
    $breadcrumbs->parent('groupmembers');
    $breadcrumbs->push($groupmembername, route('groupmembers.show', $groupmember->id));
});

// Home > groupmembers > Edit  Group Member
Breadcrumbs::register('groupmembers.edit', function($breadcrumbs, $id)
{
    $groupmember = GroupMember::findOrFail($id);
    $groupmembername = "";
    if($groupmember->branchmember) {
      $groupmembername = $groupmember->branchmember->companyuser->user->first_name;
      $groupmembername .= " " . $groupmember->branchmember->companyuser->user->last_name;
    }
    $breadcrumbs->parent('groupmembers');
    $breadcrumbs->push("Edit Group Member - " . $groupmembername, route('groupmembers.edit', $groupmember->id));
});

/******** END COMPANY BRANCH Group Members ROUTES ********/


/******** COMPANY BRANCH Members ROUTES ********/

// Home > branchmembers
Breadcrumbs::register('branchmembers', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Branch Members', route('branchmembers.index'));
});

// Home > branchmembers > Create New Branch Member
Breadcrumbs::register('branchmembers.create', function($breadcrumbs)
{
    $breadcrumbs->parent('branchmembers');
    $breadcrumbs->push('Create New Branch Member', route('branchmembers.create'));
});

// Home > branchmembers > Show Branch Member
Breadcrumbs::register('branchmembers.show', function($breadcrumbs, $id)
{
    $branchmember = BranchMember::findOrFail($id);
    $breadcrumbs->parent('branchmembers');
    $breadcrumbs->push($branchmember->name, route('branchmembers.show', $branchmember->id));
});

// Home > branchmembers > Edit Branch Member
Breadcrumbs::register('branchmembers.edit', function($breadcrumbs, $id)
{
    $branchmember = BranchMember::findOrFail($id);
    $breadcrumbs->parent('branchmembers');
    $breadcrumbs->push("Edit Branch Member - " . $branchmember->name, route('branchmembers.edit', $branchmember->id));
});

/******** END COMPANY BRANCH Members ROUTES ********/



/******** COMPANY JOIN REQUEST ROUTES ********/

// Home > company-join-requests
Breadcrumbs::register('company-join-requests', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Company Join Requests', route('company-join-requests.index'));
});

// Home > company-join-requests > Create New company-join-requests
Breadcrumbs::register('company-join-requests.create', function($breadcrumbs)
{
    $breadcrumbs->parent('company-join-requests');
    $breadcrumbs->push('Create New Join Request', route('company-join-requests.create'));
});

// Home > company-join-requests > process
Breadcrumbs::register('company-join-requests.process', function($breadcrumbs)
{
    $breadcrumbs->parent('company-join-requests');
    $breadcrumbs->push('Process Company Join Request', route('company-join-requests.process'));
});

// Home > company-join-requests > Show company-join-requests
Breadcrumbs::register('company-join-requests.show', function($breadcrumbs, $id)
{
    $breadcrumbs->parent('company-join-requests');
    $breadcrumbs->push($id, route('company-join-requests.show', $id));
});

// Home > company-join-requests > Edit company-join-requests
Breadcrumbs::register('company-join-requests.edit', function($breadcrumbs, $id)
{
    $breadcrumbs->parent('company-join-requests');
    $breadcrumbs->push("Edit Join Request - " . $id, route('company-join-requests.edit', $id));
});

/******** END COMPANY JOIN REQUEST  ROUTES ********/


/******** USER LOGIN ROUTES ********/

// Home > User Login
Breadcrumbs::register('user-logins', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('User Logins', route('user-logins.index'));
});

// Home > User Login > Create User Login
Breadcrumbs::register('user-logins.create', function($breadcrumbs)
{
    $breadcrumbs->parent('user-logins');
    $breadcrumbs->push('Create User Login', route('user-logins.create'));
});

// Home > User Login > Show User Login
Breadcrumbs::register('user-logins.show', function($breadcrumbs, $id)
{
    $breadcrumbs->parent('user-logins');
    $breadcrumbs->push("Showing User Login - " . $id, route('user-logins.show', $id));
});

// Home > User Login > Edit User Login
Breadcrumbs::register('user-logins.edit', function($breadcrumbs, $id)
{
    $breadcrumbs->parent('user-logins');
    $breadcrumbs->push("Edit User Login - " . $id, route('user-logins.edit', $id));
});

/******** END USER LOGIN ROUTES ********/



/******** MPESA PAYBILLS ROUTES ********/

// Home > Mpesa Paybills
Breadcrumbs::register('mpesa-paybills', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Mpesa Paybills', route('mpesa-paybills.index'));
});

// Home > Mpesa Paybills > Create Mpesa Paybill
Breadcrumbs::register('mpesa-paybills.create', function($breadcrumbs)
{
    $breadcrumbs->parent('mpesa-paybills');
    $breadcrumbs->push('Create Mpesa Paybill', route('mpesa-paybills.create'));
});

// Home > Mpesa Paybills > Show Mpesa Paybill
Breadcrumbs::register('mpesa-paybills.show', function($breadcrumbs, $id)
{
    $mpesapaybill = MpesaPaybill::findOrFail($id);
    $breadcrumbs->parent('mpesa-paybills');
    $breadcrumbs->push("Showing Paybill - " . $mpesapaybill->paybill_number, route('mpesa-paybills.show', $mpesapaybill->id));
});

// Home > Mpesa Paybills > Edit Mpesa Paybill
Breadcrumbs::register('mpesa-paybills.edit', function($breadcrumbs, $id)
{
    $mpesapaybill = MpesaPaybill::findOrFail($id);
    $breadcrumbs->parent('mpesa-paybills');
    $breadcrumbs->push("Edit Mpesa Paybill - " . $mpesapaybill->paybill_number, route('mpesa-paybills.edit', $mpesapaybill->id));
});

/******** END MPESA PAYBILLS ROUTES ********/



/******** PAYMENTS ROUTES ********/

// Home > payments
Breadcrumbs::register('payments', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('payments', route('payments.index'));
});

// Home > payments > Create payments
Breadcrumbs::register('payments.create', function($breadcrumbs)
{
    $breadcrumbs->parent('payments');
    $breadcrumbs->push('Create payment', route('payments.create'));
});

// Home > payments > Show payments
Breadcrumbs::register('payments.show', function($breadcrumbs, $id)
{
    $breadcrumbs->parent('payments');
    $breadcrumbs->push("Showing payment - " . $id, route('payments.show', $id));
});

// Home > payments > Edit payments
Breadcrumbs::register('payments.edit', function($breadcrumbs, $id)
{
    $breadcrumbs->parent('payments');
    $breadcrumbs->push("Edit payment - " . $id, route('payments.edit', $id));
});

/******** END PAYMENTS ROUTES ********/



/******** MPESA INCOMING ROUTES ********/

// Home > Mpesa Incoming
Breadcrumbs::register('mpesa-incoming', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Mpesa Incoming', route('mpesa-incoming.index'));
});

// Home > Mpesa Incoming > Create Mpesa Incoming
Breadcrumbs::register('mpesa-incoming.create', function($breadcrumbs)
{
    $breadcrumbs->parent('mpesa-incoming');
    $breadcrumbs->push('Create Mpesa Incoming', route('mpesa-incoming.create'));
});

// Home > Mpesa incoming > Show Mpesa Incoming
Breadcrumbs::register('mpesa-incoming.show', function($breadcrumbs, $id)
{
    $breadcrumbs->parent('mpesa-incoming');
    $breadcrumbs->push("Showing Mpesa Incoming - " . $id, route('mpesa-incoming.show', $id));
});

// Home > Mpesa incoming > Edit Mpesa Incoming
Breadcrumbs::register('mpesa-incoming.edit', function($breadcrumbs, $id)
{
    $breadcrumbs->parent('mpesa-incoming');
    $breadcrumbs->push("Edit Mpesa Incoming - " . $id, route('mpesa-incoming.edit', $id));
});

/******** END MPESA INCOMING ROUTES ********/



/******** MANAGE PRODUCTS ROUTES ********/

// Home > admin -> Product
Breadcrumbs::register('admin.products', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Products', route('admin.products.index'));
});

// Home > admin -> Product > Create Product - step 1
Breadcrumbs::register('admin.products.create', function($breadcrumbs)
{
    $breadcrumbs->parent('admin.products');
    $breadcrumbs->push('Create Product', route('admin.products.create'));
});

// Home > admin -> Product > Show Product
Breadcrumbs::register('admin.products.show', function($breadcrumbs, $id)
{
    $breadcrumbs->parent('admin.products');
    $breadcrumbs->push("Showing Product - " . $id, route('admin.products.show', $id));
});

// Home > admin -> Product > Edit Product
Breadcrumbs::register('admin.products.edit', function($breadcrumbs, $id)
{
    $breadcrumbs->parent('admin.products');
    $breadcrumbs->push("Edit Product - " . $id, route('admin.products.edit', $id));
});

/******** END MANAGE PRODUCTS ROUTES ********/


/******** MANAGE LOAN PRODUCT SETTINGS ROUTES ********/

// Home > loansetting
Breadcrumbs::register('loansettings', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Loan Product Settings', route('loansettings.index'));
});

// Home > loansetting > Create loansetting
Breadcrumbs::register('loansettings.create', function($breadcrumbs)
{
    $breadcrumbs->parent('loansettings');
    $breadcrumbs->push('Create Loan Product Settings', route('loansettings.create'));
});

// Home > loansetting > Show loansetting
Breadcrumbs::register('loansettings.show', function($breadcrumbs, $id)
{
    $breadcrumbs->parent('loansettings');
    $breadcrumbs->push("Showing Loan Product Settings - " . $id, route('loansettings.show', $id));
});

// Home > loansetting > Edit loansetting
Breadcrumbs::register('loansettings.edit', function($breadcrumbs, $id)
{
    $breadcrumbs->parent('loansettings');
    $breadcrumbs->push("Edit Loan Product Settings - " . $id, route('loansettings.edit', $id));
});

/******** END MANAGE LOAN PRODUCT SETTINGS ROUTES ********/


/******** MANAGE REMINDER MESSAGE SETTINGS ROUTES ********/

// Home > remindersetting
Breadcrumbs::register('remindersettings', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Reminder Message Settings', route('remindersettings.index'));
});

// Home > remindersetting > Create remindersetting
Breadcrumbs::register('remindersettings.create', function($breadcrumbs)
{
    $breadcrumbs->parent('remindersettings');
    $breadcrumbs->push('Create Reminder Message Settings', route('remindersettings.create'));
});

// Home > remindersetting > Show remindersetting
Breadcrumbs::register('remindersettings.show', function($breadcrumbs, $id)
{
    $breadcrumbs->parent('remindersettings');
    $breadcrumbs->push("Showing Reminder Message Settings - " . $id, route('remindersettings.show', $id));
});

// Home > remindersetting > Edit remindersetting
Breadcrumbs::register('remindersettings.edit', function($breadcrumbs, $id)
{
    $breadcrumbs->parent('remindersettings');
    $breadcrumbs->push("Edit Reminder Message Settings - " . $id, route('remindersettings.edit', $id));
});

/******** END MANAGE REMINDER MESSAGE SETTINGS ROUTES ********/


/******** MANAGE COMPANY PRODUCTS ROUTES ********/

// Home > companyproduct
Breadcrumbs::register('companyproducts', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Company Products', route('companyproducts.index'));
});

// Home > companyproduct > Create companyproduct
Breadcrumbs::register('companyproducts.create', function($breadcrumbs)
{
    $breadcrumbs->parent('companyproducts');
    $breadcrumbs->push('Create Company Product', route('companyproducts.create'));
});

// Home > companyproduct > Show companyproduct
Breadcrumbs::register('companyproducts.show', function($breadcrumbs, $id)
{
    $breadcrumbs->parent('companyproducts');
    $breadcrumbs->push("Showing Company Product - " . $id, route('companyproducts.show', $id));
});

// Home > companyproduct > Edit companyproduct
Breadcrumbs::register('companyproducts.edit', function($breadcrumbs, $id)
{
    $breadcrumbs->parent('companyproducts');
    $breadcrumbs->push("Edit Company Product - " . $id, route('companyproducts.edit', $id));
});

/******** END MANAGE COMPANY PRODUCTS ROUTES ********/


/******** MANAGE EVENTS ROUTES ********/

// Home > Event
Breadcrumbs::register('events', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('events', route('events.index'));
});

// Home > Event > Create Event - step 1
Breadcrumbs::register('events.create', function($breadcrumbs)
{
    $breadcrumbs->parent('events');
    $breadcrumbs->push('Create Event', route('events.create'));
});

// Home > Event > Show Event
Breadcrumbs::register('events.show', function($breadcrumbs, $id)
{
    $breadcrumbs->parent('events');
    $breadcrumbs->push("Showing Event - " . $id, route('events.show', $id));
});

// Home > Event > Edit Event
Breadcrumbs::register('events.edit', function($breadcrumbs, $id)
{
    $breadcrumbs->parent('events');
    $breadcrumbs->push("Edit Event - " . $id, route('events.edit', $id));
});

/******** END MANAGE EVENTS ROUTES ********/



/******** LOAN APPLICATION ROUTES ********/

// Home > Loan Application
Breadcrumbs::register('loan-applications', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Loan Applications', route('loan-applications.index'));
});

// Home > Loan Application > Create Loan Application - step 1
Breadcrumbs::register('loan-applications.create', function($breadcrumbs)
{
    $breadcrumbs->parent('loan-applications');
    $breadcrumbs->push('Create Loan Application', route('loan-applications.create'));
});

// Home > Loan Application > Create Loan Application - step 2
Breadcrumbs::register('loan-applications.create_step2', function($breadcrumbs)
{
    $breadcrumbs->parent('loan-applications.create');
    $breadcrumbs->push('Create Loan Application - Step 2', route('loan-applications.create_step2'));
});

// Home > Loan Application > Approve Loan Application
Breadcrumbs::register('loan-applications.approve', function($breadcrumbs, $id)
{
    $breadcrumbs->parent('loan-applications');
    $breadcrumbs->push('Approve Loan Application - ' . $id, route('loan-applications.approve', $id));
});

// Home > Loan Application > Show Loan Application
Breadcrumbs::register('loan-applications.show', function($breadcrumbs, $id)
{
    $breadcrumbs->parent('loan-applications');
    $breadcrumbs->push("Showing Loan Application - " . $id, route('loan-applications.show', $id));
});

// Home > Loan Application > Edit Loan Application
Breadcrumbs::register('loan-applications.edit', function($breadcrumbs, $id)
{
    $breadcrumbs->parent('loan-applications');
    $breadcrumbs->push("Edit Loan Application - " . $id, route('loan-applications.edit', $id));
});

/******** END LOAN APPLICATION ROUTES ********/




/******** LOAN EXPOSURE LIMIT ROUTES ********/

// Home > Loan Exposure Limits
Breadcrumbs::register('loan-exposure-limits', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Loan Exposure Limits', route('loan-exposure-limits.index'));
});

// Home > Loan Exposure Limits > Show Loan Exposure Limits
Breadcrumbs::register('loan-exposure-limits.show', function($breadcrumbs, $id)
{
    $breadcrumbs->parent('loan-exposure-limits');
    $breadcrumbs->push("Showing Loan Exposure Limits - " . $id, route('loan-exposure-limits.show', $id));
});

// Home > Loan Exposure Limits > Edit Loan Exposure Limits
Breadcrumbs::register('loan-exposure-limits.edit', function($breadcrumbs, $id)
{
    $breadcrumbs->parent('loan-exposure-limits');
    $breadcrumbs->push("Edit Loan Exposure Limits - " . $id, route('loan-exposure-limits.edit', $id));
});

/******** END LOAN EXPOSURE LIMIT ROUTES ********/



/******** USER SAVINGS ACCOUNTS ROUTES ********/

// Home > User Savings Accounts
Breadcrumbs::register('user-savings-accounts', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('User Savings Accounts', route('user-savings-accounts.index'));
});

// Home > User Savings Account > Create User Savings Accounts
Breadcrumbs::register('user-savings-accounts.create', function($breadcrumbs)
{
    $breadcrumbs->parent('user-savings-accounts');
    $breadcrumbs->push('Create Account', route('user-savings-accounts.create'));
});

// Home > User Savings Account > Show User Savings Account
Breadcrumbs::register('user-savings-accounts.show', function($breadcrumbs, $id)
{
    $breadcrumbs->parent('user-savings-accounts');
    $breadcrumbs->push("Showing Account - " . $id, route('user-savings-accounts.show', $id));
});

// Home > User Savings Account > Edit User Savings Account
Breadcrumbs::register('user-savings-accounts.edit', function($breadcrumbs, $id)
{
    $breadcrumbs->parent('user-savings-accounts');
    $breadcrumbs->push("Edit User Savings Account - " . $id, route('user-savings-accounts.edit', $id));
});

/******** END USER SAVINGS  ROUTES ********/


/******** USER DEPOSIT ACCOUNTS HISTORY ROUTES ********/

// Home > User Deposit Accounts History
Breadcrumbs::register('deposit-accounts-history', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Deposit Accounts History', route('deposit-accounts-history.index'));
});

// Home > User Deposit Account History > Create User Deposit Accounts History
Breadcrumbs::register('deposit-accounts-history.create', function($breadcrumbs)
{
    $breadcrumbs->parent('deposit-accounts-history');
    $breadcrumbs->push('Create Deposit Account History', route('deposit-accounts-history.create'));
});

// Home > User Deposit Account History > Show User Deposit Account History
Breadcrumbs::register('deposit-accounts-history.show', function($breadcrumbs, $id)
{
    $breadcrumbs->parent('deposit-accounts-history');
    $breadcrumbs->push("Showing Account - " . $id, route('deposit-accounts-history.show', $id));
});

// Home > User Deposit Account History > Edit User Deposit Account History
Breadcrumbs::register('deposit-accounts-history.edit', function($breadcrumbs, $id)
{
    $breadcrumbs->parent('deposit-accounts-history');
    $breadcrumbs->push("Edit User Deposit Account  History - " . $id, route('deposit-accounts-history.edit', $id));
});

/******** END DEPOSIT ACCOUNTS HISTORY ROUTES ********/


/******** USER DEPOSIT ACCOUNTS SUMMARY ROUTES ********/

// Home > User Deposit Accounts Summary
Breadcrumbs::register('deposit-accounts-summary', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Deposit Accounts Summary', route('deposit-accounts-summary.index'));
});

// Home > User Deposit Account Summary > Create User Deposit Accounts Summary
Breadcrumbs::register('deposit-accounts-summary.create', function($breadcrumbs)
{
    $breadcrumbs->parent('deposit-accounts-summary');
    $breadcrumbs->push('Create Deposit Account Summary', route('deposit-accounts-summary.create'));
});

// Home > User Deposit Account Summary > Show User Deposit Account Summary
Breadcrumbs::register('deposit-accounts-summary.show', function($breadcrumbs, $id)
{
    $breadcrumbs->parent('deposit-accounts-summary');
    $breadcrumbs->push("Showing Account - " . $id, route('deposit-accounts-summary.show', $id));
});

// Home > User Deposit Account Summary > Edit User Deposit Account Summary
Breadcrumbs::register('deposit-accounts-summary.edit', function($breadcrumbs, $id)
{
    $breadcrumbs->parent('deposit-accounts-summary');
    $breadcrumbs->push("Edit User Deposit Account Summary - " . $id, route('deposit-accounts-summary.edit', $id));
});

/******** END DEPOSIT ACCOUNTS SUMMARY ROUTES ********/




//////////////////////////////////////////////////////////////////////
/******** USER SHARES ACCOUNTS HISTORY ROUTES ********/

// Home > User Shares Accounts History
Breadcrumbs::register('shares-accounts-history', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Shares Accounts History', route('shares-accounts-history.index'));
});

// Home > User Shares Account History > Create User Shares Accounts History
Breadcrumbs::register('shares-accounts-history.create', function($breadcrumbs)
{
    $breadcrumbs->parent('shares-accounts-history');
    $breadcrumbs->push('Create Shares Account History', route('shares-accounts-history.create'));
});

// Home > User Shares Account History > Show User Shares Account History
Breadcrumbs::register('shares-accounts-history.show', function($breadcrumbs, $id)
{
    $breadcrumbs->parent('shares-accounts-history');
    $breadcrumbs->push("Showing Account - " . $id, route('shares-accounts-history.show', $id));
});

// Home > User Shares Account History > Edit User Shares Account History
Breadcrumbs::register('shares-accounts-history.edit', function($breadcrumbs, $id)
{
    $breadcrumbs->parent('shares-accounts-history');
    $breadcrumbs->push("Edit User Shares Account  History - " . $id, route('shares-accounts-history.edit', $id));
});

/******** END SHARES ACCOUNTS HISTORY ROUTES ********/


/******** USER SHARES ACCOUNTS SUMMARY ROUTES ********/

// Home > User Shares Accounts Summary
Breadcrumbs::register('shares-accounts-summary', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Shares Accounts Summary', route('shares-accounts-summary.index'));
});

// Home > User Shares Account Summary > Create User Shares Accounts Summary
Breadcrumbs::register('shares-accounts-summary.create', function($breadcrumbs)
{
    $breadcrumbs->parent('shares-accounts-summary');
    $breadcrumbs->push('Create Shares Account Summary', route('shares-accounts-summary.create'));
});

// Home > User Shares Account Summary > Show User Shares Account Summary
Breadcrumbs::register('shares-accounts-summary.show', function($breadcrumbs, $id)
{
    $breadcrumbs->parent('shares-accounts-summary');
    $breadcrumbs->push("Showing Account - " . $id, route('shares-accounts-summary.show', $id));
});

// Home > User Shares Account Summary > Edit User Shares Account Summary
Breadcrumbs::register('shares-accounts-summary.edit', function($breadcrumbs, $id)
{
    $breadcrumbs->parent('shares-accounts-summary');
    $breadcrumbs->push("Edit User Shares Account Summary - " . $id, route('shares-accounts-summary.edit', $id));
});

/******** END SHARES ACCOUNTS SUMMARY ROUTES ********/
/////////////////////////////////////////////////////////////////////




/******** GL ACCOUNTS ROUTES ********/

// Home > GL Accounts History
Breadcrumbs::register('glaccounts', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('GL Accounts', route('glaccounts.index'));
});

// Home > GL Account > Create GL Accounts
Breadcrumbs::register('glaccounts.create', function($breadcrumbs)
{
    $breadcrumbs->parent('glaccounts');
    $breadcrumbs->push('Create GL Account', route('glaccounts.create'));
});

// Home > GL Account > Show GL Account
Breadcrumbs::register('glaccounts.show', function($breadcrumbs, $id)
{
    $breadcrumbs->parent('glaccounts');
    $breadcrumbs->push("Showing GL Account - " . $id, route('glaccounts.show', $id));
});

// Home > GL Account > Edit GL Account
Breadcrumbs::register('glaccounts.edit', function($breadcrumbs, $id)
{
    $breadcrumbs->parent('glaccounts');
    $breadcrumbs->push("Edit GL Account  - " . $id, route('glaccounts.edit', $id));
});

/******** END GL ACCOUNTS ROUTES ********/


/******** GL ACCOUNTS HISTORY ROUTES ********/

// Home > GL Accounts History
Breadcrumbs::register('gl-accounts-history', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('GL Accounts History', route('gl-accounts-history.index'));
});

// Home > GL Account History > Create GL Accounts History
Breadcrumbs::register('gl-accounts-history.create', function($breadcrumbs)
{
    $breadcrumbs->parent('gl-accounts-history');
    $breadcrumbs->push('Create GL History', route('gl-accounts-history.create'));
});

// Home > GL Account History > Show GL Account History
Breadcrumbs::register('gl-accounts-history.show', function($breadcrumbs, $id)
{
    $breadcrumbs->parent('gl-accounts-history');
    $breadcrumbs->push("Showing GL Account - " . $id, route('gl-accounts-history.show', $id));
});

// Home > GL Account History > Edit GL Account History
Breadcrumbs::register('gl-accounts-history.edit', function($breadcrumbs, $id)
{
    $breadcrumbs->parent('gl-accounts-history');
    $breadcrumbs->push("Edit GL Account  History - " . $id, route('gl-accounts-history.edit', $id));
});

/******** END GL ACCOUNTS HISTORY ROUTES ********/


/******** GL ACCOUNTS SUMMARY ROUTES ********/

// Home > GL Accounts Summary
Breadcrumbs::register('gl-accounts-summary', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('GL Accounts Summary', route('gl-accounts-summary.index'));
});

// Home > GL Account Summary > Create GL Accounts Summary
Breadcrumbs::register('gl-accounts-summary.create', function($breadcrumbs)
{
    $breadcrumbs->parent('gl-accounts-summary');
    $breadcrumbs->push('Create GL Summary', route('gl-accounts-summary.create'));
});

// Home > GL Account Summary > Show GL Account Summary
Breadcrumbs::register('gl-accounts-summary.show', function($breadcrumbs, $id)
{
    $breadcrumbs->parent('gl-accounts-summary');
    $breadcrumbs->push("Showing GL Account - " . $id, route('gl-accounts-summary.show', $id));
});

// Home > GL Account Summary > Edit GL Account Summary
Breadcrumbs::register('gl-accounts-summary.edit', function($breadcrumbs, $id)
{
    $breadcrumbs->parent('gl-accounts-summary');
    $breadcrumbs->push("Edit GL Account  Summary - " . $id, route('gl-accounts-summary.edit', $id));
});

/******** END GL ACCOUNTS SUMMARY ROUTES ********/


/******** ASSETS ROUTES ********/

// Home > Assets
Breadcrumbs::register('assets', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Assets', route('assets.index'));
});

// Home > Assets > Create Assets
Breadcrumbs::register('assets.create', function($breadcrumbs)
{
    $breadcrumbs->parent('assets');
    $breadcrumbs->push('Create Assets', route('assets.create'));
});

// Home > Assets > Show Assets
Breadcrumbs::register('assets.show', function($breadcrumbs, $id)
{
    $breadcrumbs->parent('assets');
    $breadcrumbs->push("Showing Asset - " . $id, route('assets.show', $id));
});

// Home > Assets > Edit Assets
Breadcrumbs::register('assets.edit', function($breadcrumbs, $id)
{
    $breadcrumbs->parent('assets');
    $breadcrumbs->push("Edit Asset - " . $id, route('assets.edit', $id));
});

/******** END ASSETS ROUTES ********/


/******** LOAN ACCOUNTS ROUTES ********/

// Home > Loan Accounts
Breadcrumbs::register('loan-accounts', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Loan Accounts', route('loan-accounts.index'));
});

// Home > Loan Account > Create Loan Accounts
Breadcrumbs::register('loan-accounts.create', function($breadcrumbs)
{
    $breadcrumbs->parent('loan-accounts');
    $breadcrumbs->push('Create Loan Account', route('loan-accounts.create'));
});

// Home > Loan Account > Create Loan Accounts - step2
Breadcrumbs::register('loan-accounts.create_step2', function($breadcrumbs)
{
    $breadcrumbs->parent('loan-accounts.create');
    $breadcrumbs->push('Create Loan Account - Step 2', route('loan-accounts.create_step2'));
});

// Home > Loan Account > Create Loan Accounts - step3
Breadcrumbs::register('loan-accounts.create_step3', function($breadcrumbs)
{
    $breadcrumbs->parent('loan-accounts.create_step2');
    $breadcrumbs->push('Create Loan Account - Step 3', route('loan-accounts.create_step3'));
});

// Home > Loan Account > Show Loan Account
Breadcrumbs::register('loan-accounts.show', function($breadcrumbs, $id)
{
    $breadcrumbs->parent('loan-accounts');
    $breadcrumbs->push("Showing Loan Account - " . $id, route('loan-accounts.show', $id));
});

// Home > Loan Account > Edit Loan Account
Breadcrumbs::register('loan-accounts.edit', function($breadcrumbs, $id)
{
    $breadcrumbs->parent('loan-accounts');
    $breadcrumbs->push("Edit Loan Account - " . $id, route('loan-accounts.edit', $id));
});

/******** END LOAN ROUTES ********/


/******** SAVINGS DEPOSIT ACCOUNTS ROUTES ********/

// Home > Savings Deposit Accounts
Breadcrumbs::register('savings-deposit-accounts', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Savings Deposit Accounts', route('savings-deposit-accounts.index'));
});

// Home > Savings Deposit Account > Create Savings Deposit Account
Breadcrumbs::register('savings-deposit-accounts.create', function($breadcrumbs)
{
    $breadcrumbs->parent('savings-deposit-accounts');
    $breadcrumbs->push('Create Savings Deposit Account', route('savings-deposit-accounts.create'));
});

// Home > Savings Deposit Account > Show Savings Deposit Account
Breadcrumbs::register('savings-deposit-accounts.show', function($breadcrumbs, $id)
{
    $breadcrumbs->parent('savings-deposit-accounts');
    $breadcrumbs->push("Showing Account - " . $id, route('savings-deposit-accounts.show', $id));
});

// Home > Savings Deposit Account > Edit Savings Deposit Account
Breadcrumbs::register('savings-deposit-accounts.edit', function($breadcrumbs, $id)
{
    $breadcrumbs->parent('savings-deposit-accounts');
    $breadcrumbs->push("Edit Savings Deposit Account - " . $id, route('savings-deposit-accounts.edit', $id));
});

/******** END SAVINGS DEPOSIT ACCOUNTS ROUTES ********/



/******** LOAN REPAYMENTS DEPOSIT ACCOUNTS ROUTES ********/

// Home > Loan Repayments Deposit Accounts
Breadcrumbs::register('loan-repayments-deposit-accounts', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Loan Repayments Deposit Accounts', route('loan-repayments-deposit-accounts.index'));
});

// Home > Loan Repayments Deposit Account > Create Loan Repayments Deposit Account
Breadcrumbs::register('loan-repayments-deposit-accounts.create', function($breadcrumbs)
{
    $breadcrumbs->parent('loan-repayments-deposit-accounts');
    $breadcrumbs->push('Create Loan Repayments Deposit Account', route('loan-repayments-deposit-accounts.create'));
});

// Home > Loan Repayments Deposit Account > Show Loan Repayments Deposit Account
Breadcrumbs::register('loan-repayments-deposit-accounts.show', function($breadcrumbs, $id)
{
    $breadcrumbs->parent('loan-repayments-deposit-accounts');
    $breadcrumbs->push("Showing Account - " . $id, route('loan-repayments-deposit-accounts.show', $id));
});

// Home > Loan Repayments Deposit Account > Edit Loan Repayments Deposit Account
Breadcrumbs::register('loan-repayments-deposit-accounts.edit', function($breadcrumbs, $id)
{
    $breadcrumbs->parent('loan-repayments-deposit-accounts');
    $breadcrumbs->push("Edit Loan Repayments Deposit Account - " . $id, route('loan-repayments-deposit-accounts.edit', $id));
});

/******** END LOAN REPAYMENTS DEPOSIT ACCOUNTS ROUTES ********/



/******** USSD REGISTRATION ROUTES ********/

// Home > USSD Registration
Breadcrumbs::register('ussd-registration', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('USSD Registration', route('ussd-registration.index'));
});

// Home > USSD Registration > Create USSD Registration
Breadcrumbs::register('ussd-registration.create', function($breadcrumbs)
{
    $breadcrumbs->parent('ussd-registration');
    $breadcrumbs->push('Create USSD Registration', route('ussd-registration.create'));
});

// Home > USSD Registration > Show USSD Registration
Breadcrumbs::register('ussd-registration.show', function($breadcrumbs, $id)
{
    $breadcrumbs->parent('ussd-registration');
    $breadcrumbs->push("Showing USSD Registration - " . $id, route('ussd-registration.show', $id));
});

// Home > USSD Registration > Edit USSD Registration
Breadcrumbs::register('ussd-registration.edit', function($breadcrumbs, $id)
{
    $breadcrumbs->parent('ussd-registration');
    $breadcrumbs->push("Edit USSD Registration - " . $id, route('ussd-registration.edit', $id));
});

/******** END USSD REGISTRATION ROUTES ********/



/******** USSD EVENTS ROUTES ********/

// Home > USSD Event
Breadcrumbs::register('ussd-events', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('USSD Events', route('ussd-events.index'));
});

// Home > USSD Event > Create USSD Event
Breadcrumbs::register('ussd-events.create', function($breadcrumbs)
{
    $breadcrumbs->parent('ussd-events');
    $breadcrumbs->push('Create USSD Event', route('ussd-events.create'));
});

// Home > USSD Event > Show USSD Event
Breadcrumbs::register('ussd-events.show', function($breadcrumbs, $id)
{
    //get event name
    $event_data = UssdEvent::find($id);
    $event_name = $event_data->name;
    $breadcrumbs->parent('ussd-events');
    $breadcrumbs->push("Showing USSD Event - " . $id . " - " . $event_name, route('ussd-events.show', $id));
});

// Home > USSD Event > Edit USSD Event
Breadcrumbs::register('ussd-events.edit', function($breadcrumbs, $id)
{
    $breadcrumbs->parent('ussd-events');
    $breadcrumbs->push("Edit USSD Event - " . $id, route('ussd-events.edit', $id));
});

/******** END USSD EVENTS ROUTES ********/



/******** USSD PAYMENTS ROUTES ********/

// Home > USSD Payment
Breadcrumbs::register('ussd-payments', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('USSD Payments', route('ussd-payments.index'));
});

// Home > USSD Payment > Create USSD Payment
Breadcrumbs::register('ussd-payments.create', function($breadcrumbs)
{
    $breadcrumbs->parent('ussd-payments');
    $breadcrumbs->push('Create USSD Payment', route('ussd-payments.create'));
});

// Home > USSD Payment > Show USSD Payment
Breadcrumbs::register('ussd-payments.show', function($breadcrumbs, $id)
{
    $breadcrumbs->parent('ussd-payments');
    $breadcrumbs->push("Showing USSD Payment - " . $id, route('ussd-payments.show', $id));
});

// Home > USSD Payment > Edit USSD Payment
Breadcrumbs::register('ussd-payments.edit', function($breadcrumbs, $id)
{
    $breadcrumbs->parent('ussd-payments');
    $breadcrumbs->push("Edit USSD Payment - " . $id, route('ussd-payments.edit', $id));
});

/******** END USSD PAYMENTS ROUTES ********/



/******** USSD RECOMMENDS ROUTES ********/

// Home > USSD Recommend
Breadcrumbs::register('ussd-recommends', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('USSD Recommends', route('ussd-recommends.index'));
});

// Home > USSD Recommend > Create USSD Recommend
Breadcrumbs::register('ussd-recommends.create', function($breadcrumbs)
{
    $breadcrumbs->parent('ussd-recommends');
    $breadcrumbs->push('Create USSD Recommend', route('ussd-recommends.create'));
});

// Home > USSD Recommend > Show USSD Recommend
Breadcrumbs::register('ussd-recommends.show', function($breadcrumbs, $id)
{
    $breadcrumbs->parent('ussd-recommends');
    $breadcrumbs->push("Showing USSD Recommend - " . $id, route('ussd-recommends.show', $id));
});

// Home > USSD Recommend > Edit USSD Recommend
Breadcrumbs::register('ussd-recommends.edit', function($breadcrumbs, $id)
{
    $breadcrumbs->parent('ussd-recommends');
    $breadcrumbs->push("Edit USSD Recommend - " . $id, route('ussd-recommends.edit', $id));
});

/******** END USSD RECOMMENDS ROUTES ********/



/******** CONTACTUS ROUTES ********/

// Home > Contact Us
Breadcrumbs::register('contacts.index', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Contact Us', route('contacts'));
});

// Home > Contact Us > Create Contact Us
Breadcrumbs::register('contacts.create', function($breadcrumbs)
{
    $breadcrumbs->parent('contacts.index');
    $breadcrumbs->push('Contact Us', route('contacts.create'));
});

// Home > Contact Us > Show Contact Us
Breadcrumbs::register('contacts.show', function($breadcrumbs, $id)
{
    $breadcrumbs->parent('contacts.index');
    $breadcrumbs->push("Showing Contact Us - " . $id, route('contacts.show', $id));
});

// Home > Contact Us > Edit Contact Us
Breadcrumbs::register('contacts.edit', function($breadcrumbs, $id)
{
    $breadcrumbs->parent('contacts.index');
    $breadcrumbs->push("Edit Contact Us - " . $id, route('contacts.edit', $id));
});

/******** END CONTACTUS ROUTES ********/


/******** PERMISSIONS ROUTES ********/

// Home > Permissions
Breadcrumbs::register('permissions', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Permissions', route('permissions.index'));
});

// Home > Permissions > Create New Permission
Breadcrumbs::register('permissions.create', function($breadcrumbs)
{
    $breadcrumbs->parent('permissions');
    $breadcrumbs->push('Create New Permission', route('permissions.create'));
});

// Home > Permissions > Show Permission
Breadcrumbs::register('permissions.show', function($breadcrumbs, $id)
{
    $permission = Permission::findOrFail($id);
    $breadcrumbs->parent('permissions');
    $breadcrumbs->push($permission->display_name, route('permissions.show', $permission->id));
});

// Home > Permissions > Edit Permission
Breadcrumbs::register('permissions.edit', function($breadcrumbs, $id)
{
    $permission = Permission::findOrFail($id);
    $breadcrumbs->parent('permissions');
    $breadcrumbs->push("Edit permission - " . $permission->display_name, route('permissions.edit', $permission->id));
});

/******** END PERMISSIONS ROUTES ********/


/******** ROLES ROUTES ********/

// Home > Roles
Breadcrumbs::register('roles', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('roles', route('roles.index'));
});

// Home > Roles > Create New Role
Breadcrumbs::register('roles.create', function($breadcrumbs)
{
    $breadcrumbs->parent('roles');
    $breadcrumbs->push('Create New Role', route('roles.create'));
});

// Home > Roles > Show Role
Breadcrumbs::register('roles.show', function($breadcrumbs, $id)
{
    $role = Role::findOrFail($id);
    $breadcrumbs->parent('roles');
    $breadcrumbs->push($role->display_name, route('roles.show', $role->id));
});

// Home > Roles > Edit Role
Breadcrumbs::register('roles.edit', function($breadcrumbs, $id)
{
    $role = Role::findOrFail($id);
    $breadcrumbs->parent('roles');
    $breadcrumbs->push("Edit role - " . $role->display_name, route('roles.edit', $role->id));
});

/******** END ROLES ROUTES ********/



/******** USERS ROUTES ********/

// Home > Users
Breadcrumbs::register('users', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Users', route('users.index'));
});

// Home > Users > Create New User
Breadcrumbs::register('users.create', function($breadcrumbs)
{
    $breadcrumbs->parent('users');
    $breadcrumbs->push('Create New User', route('users.create'));
});

// Home > Users > Create Bulk User Accounts
Breadcrumbs::register('bulk-users.create', function($breadcrumbs)
{
    $breadcrumbs->parent('users');
    $breadcrumbs->push('Create Bulk User Accounts', route('bulk-users.create'));
});

// Home > Users > Show User
Breadcrumbs::register('users.show', function($breadcrumbs, $id)
{
    $company_user = CompanyUser::findOrFail($id);
    $full_names = $company_user->user->first_name . ' ' . $company_user->user->last_name;
    $breadcrumbs->parent('users');
    $breadcrumbs->push($full_names, route('users.show', $company_user->id));
});

// Home > Users > Edit User
Breadcrumbs::register('users.edit', function($breadcrumbs, $id)
{
    $company_user = CompanyUser::findOrFail($id);
    $full_names = $company_user->user->first_name . ' ' . $company_user->user->last_name;
    $breadcrumbs->parent('users');
    $breadcrumbs->push("Edit user - " . $full_names, route('users.edit', $company_user->id));
});


/******** END USERS ROUTES ********/



/******** LOGGED USER ROUTES ********/

// Home > My Profile
Breadcrumbs::register('user.profile', function($breadcrumbs)
{
    if(request()->has('id')) {
        $id=request()->id;
    } else {
        $id = auth()->user()->id;
    }
    $user = User::findOrFail($id);
    $full_names = $user->first_name;
    $breadcrumbs->parent('home');
    $breadcrumbs->push("$full_names profile", route('user.profile'));
});

/*Breadcrumbs::register('user.profile.id', function($breadcrumbs, $id)
{
    $user = User::findOrFail($id);
    $full_names = $user->first_name . ' ' . $user->last_name;
    $breadcrumbs->parent('home');
    $breadcrumbs->push("$full_names profile", route('user.profile.id'));
});*/

// Home > Users > Change My Password
Breadcrumbs::register('user.changepass', function($breadcrumbs)
{
    $breadcrumbs->parent('user.profile');
    $breadcrumbs->push("Change My Password", route('user.changepass'));
});
/******** END LOGGED USER ROUTES ********/
