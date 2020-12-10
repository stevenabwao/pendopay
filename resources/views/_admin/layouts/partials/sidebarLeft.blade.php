<div class="fixed-sidebar-left">
   <ul class="nav navbar-nav side-nav nicescroll-bar">
      <li class="navigation-header">
         <span>
            {{ Auth::user()->first_name }}
            &nbsp;
            {{ Auth::user()->last_name }}
         </span>
      </li>

      @if ((!isSuperAdmin()) && ($user->company))
      <li class="navigation-header">
            <span class="pb-0">{{ $user->company->name }}</span>
      </li>

      <li><hr class="light-grey-hr mb-10 mt-10"/></li>
      @endif

      <li>
         <a href="{{ route('admin.home') }}" class="active">
            <div class="pull-left">
               <i class="zmdi zmdi-landscape mr-20"></i>
               <span class="right-nav-text">Dashboard</span>
            </div>
            <div class="pull-right">
            </div>
            <div class="clearfix"></div>
         </a>
      </li>

      @if (Auth::user()->hasRole('superadministrator'))
      <li>
         <a href="javascript:void(0);" data-toggle="collapse" data-target="#companies_dr">
            <div class="pull-left">
               <i class="zmdi zmdi-apps mr-20"></i>
               <span class="right-nav-text">Establishments </span>
            </div>
            <div class="pull-right">
               <i class="zmdi zmdi-caret-down"></i>
            </div>
            <div class="clearfix"></div>
         </a>
         <ul id="companies_dr" class="collapse collapse-level-1">

            <li>
               <a href="{{ route('admin.establishments.create') }}">
                  <i class="zmdi zmdi-accounts-add mr-10"></i>
                  <span class="right-nav-text">New</span>
               </a>
            </li>

            <li>
               <a href="{{ route('admin.establishments.index') }}">
                  <i class="fa fa-users mr-10"></i>
                  <span class="right-nav-text">Manage Establishments</span>
               </a>
            </li>

         </ul>
      </li>

      @endif



      @if ((isSuperAdmin()) || (isAdmin()))

         <li>
            <a href="javascript:void(0);" data-toggle="collapse" data-target="#manage_dr">
               <div class="pull-left">
                  <i class="zmdi zmdi-accounts mr-20"></i>
                  <span class="right-nav-text">Manage </span>
               </div>
               <div class="pull-right">
                  <i class="zmdi zmdi-caret-down"></i>
               </div>
               <div class="clearfix"></div>
            </a>
            <ul id="manage_dr" class="collapse collapse-level-1">

                <li>
                    <a href="javascript:void(0);" data-toggle="collapse" data-target="#users_dr">
                        <div class="pull-left">
                            <i class="zmdi zmdi-accounts mr-20"></i>
                            <span class="right-nav-text">Users </span>
                        </div>
                        <div class="pull-right">
                            <i class="zmdi zmdi-caret-down"></i>
                        </div>
                        <div class="clearfix"></div>
                    </a>
                    <ul id="users_dr" class="collapse collapse-level-1">

                        <li>
                            <a href="{{ route('users.create') }}">
                            <i class="zmdi zmdi-account-add mr-10"></i>
                            <span class="right-nav-text">Create Single</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('bulk-users.create') }}">
                            <i class="zmdi zmdi-accounts-add mr-10"></i>
                            <span class="right-nav-text">Create Bulk</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('users.index') }}">
                            <i class="zmdi zmdi-accounts-list mr-10"></i>
                            <span class="right-nav-text">Manage Users</span>
                            </a>
                        </li>

                    </ul>
                </li>


                {{-- @if (isSuperAdmin())

                    <li>
                        <a href="javascript:void(0);" data-toggle="collapse" data-target="#perms_dr">
                            <div class="pull-left">
                            <i class="zmdi zmdi-lock-outline mr-20"></i>
                            <span class="right-nav-text">Permissions</span>
                            </div>
                            <div class="pull-right">
                            <i class="zmdi zmdi-caret-down"></i>
                            </div>
                            <div class="clearfix"></div>
                        </a>
                        <ul id="perms_dr" class="collapse collapse-level-1">

                            <li>
                            <a href="{{ route('permissions.create') }}">
                                <i class="zmdi zmdi-accounts-add mr-10"></i>
                                <span class="right-nav-text">New</span>
                            </a>
                            </li>
                            <li>
                            <a href="{{ route('permissions.index') }}">
                                <i class="fa fa-users mr-10"></i>
                                <span class="right-nav-text">Manage</span>
                            </a>
                            </li>

                        </ul>
                    </li>

                    <li>
                        <a href="javascript:void(0);" data-toggle="collapse" data-target="#roles_dr">
                            <div class="pull-left">
                            <i class="zmdi zmdi-lock-outline mr-20"></i>
                            <span class="right-nav-text">Roles </span>
                            </div>
                            <div class="pull-right">
                            <i class="zmdi zmdi-caret-down"></i>
                            </div>
                            <div class="clearfix"></div>
                        </a>
                        <ul id="roles_dr" class="collapse collapse-level-1">

                            <li>
                            <a href="{{ route('roles.create') }}">
                                <i class="zmdi zmdi-accounts-add mr-10"></i>
                                <span class="right-nav-text">New</span>
                            </a>
                            </li>
                            <li>
                            <a href="{{ route('roles.index') }}">
                                <i class="fa fa-users mr-10"></i>
                                <span class="right-nav-text">Manage</span>
                            </a>
                            </li>

                        </ul>
                    </li>

                @endif --}}


                @if (isSuperAdmin())

                    <li>
                        <a href="javascript:void(0);" data-toggle="collapse" data-target="#mpesapaybills_dr">
                            <div class="pull-left">
                                <i class="zmdi zmdi-lock-outline mr-20"></i>
                                <span class="right-nav-text">Mpesa Paybills </span>
                            </div>
                            <div class="pull-right">
                                <i class="zmdi zmdi-caret-down"></i>
                            </div>
                            <div class="clearfix"></div>
                        </a>
                        <ul id="mpesapaybills_dr" class="collapse collapse-level-1">

                            <li>
                                <a href="{{ route('mpesa-paybills.create') }}">
                                <i class="zmdi zmdi-accounts-add mr-10"></i>
                                <span class="right-nav-text">Create Mpesa Paybill</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('mpesa-paybills.index') }}">
                                <i class="fa fa-users mr-10"></i>
                                <span class="right-nav-text">Manage Mpesa Paybills</span>
                                </a>
                            </li>

                        </ul>
                    </li>


                    <li>
                        <a href="javascript:void(0);" data-toggle="collapse" data-target="#mpesashortcodes_dr">
                            <div class="pull-left">
                                <i class="zmdi zmdi-lock-outline mr-20"></i>
                                <span class="right-nav-text">Mpesa Shortcodes </span>
                            </div>
                            <div class="pull-right">
                                <i class="zmdi zmdi-caret-down"></i>
                            </div>
                            <div class="clearfix"></div>
                        </a>
                        <ul id="mpesashortcodes_dr" class="collapse collapse-level-1">

                            <li>
                                <a href="{{ route('mpesa-paybills.create') }}">
                                <i class="zmdi zmdi-accounts-add mr-10"></i>
                                <span class="right-nav-text">Create Mpesa Shortcode</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('mpesa-paybills.index') }}">
                                <i class="fa fa-users mr-10"></i>
                                <span class="right-nav-text">Manage Mpesa Shortcodes</span>
                                </a>
                            </li>

                        </ul>
                    </li>


                    <li>
                        <a href="javascript:void(0);" data-toggle="collapse" data-target="#till_dr">
                           <div class="pull-left">
                              <i class="zmdi zmdi-case mr-20"></i>
                              <span class="right-nav-text">Tills </span>
                           </div>
                           <div class="pull-right">
                              <i class="zmdi zmdi-caret-down"></i>
                           </div>
                           <div class="clearfix"></div>
                        </a>
                        <ul id="till_dr" class="collapse collapse-level-1">


                           <li>
                              <a href="{{ route('admin.tills.create') }}">
                                 <i class="zmdi zmdi-account-add mr-10"></i>
                                 <span class="right-tillnav-text">New</span>
                              </a>
                           </li>
                           <li>
                              <a href="{{ route('admin.tills.index') }}">
                                 <i class="zmdi zmdi-accounts-add mr-10"></i>
                                 <span class="right-nav-text">Manage</span>
                              </a>
                           </li>


                        </ul>
                    </li>


                    <li>
                        <a href="javascript:void(0);" data-toggle="collapse" data-target="#products_dr">
                            <div class="pull-left">
                            <i class="zmdi zmdi-accounts mr-20"></i>
                            <span class="right-nav-text">Products </span>
                            </div>
                            <div class="pull-right">
                            <i class="zmdi zmdi-caret-down"></i>
                            </div>
                            <div class="clearfix"></div>
                        </a>
                        <ul id="products_dr" class="collapse collapse-level-1">

                            <li>
                            <a href="{{ route('admin.products.create') }}">
                                <i class="zmdi zmdi-account-add mr-10"></i>
                                <span class="right-nav-text">New</span>
                            </a>
                            </li>
                            <li>
                            <a href="{{ route('admin.products.index') }}">
                                <i class="zmdi zmdi-accounts-add mr-10"></i>
                                <span class="right-nav-text">Manage</span>
                            </a>
                            </li>

                        </ul>
                    </li>


                    <li>
                        <a href="javascript:void(0);" data-toggle="collapse" data-target="#companyproducts_dr">
                        <div class="pull-left">
                            <i class="zmdi zmdi-accounts mr-20"></i>
                            <span class="right-nav-text">Establishment Products </span>
                        </div>
                        <div class="pull-right">
                            <i class="zmdi zmdi-caret-down"></i>
                        </div>
                        <div class="clearfix"></div>
                        </a>
                        <ul id="companyproducts_dr" class="collapse collapse-level-1">

                        <li>
                            <a href="{{ route('admin.companyproducts.create') }}">
                                <i class="zmdi zmdi-account-add mr-10"></i>
                                <span class="right-nav-text">New</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.companyproducts.index') }}">
                                <i class="zmdi zmdi-accounts-add mr-10"></i>
                                <span class="right-nav-text">Manage</span>
                            </a>
                        </li>

                        </ul>
                    </li>

               @endif

                <li>
                    <a href="javascript:void(0);" data-toggle="collapse" data-target="#offers_dr">
                    <div class="pull-left">
                        <i class="zmdi zmdi-collection-item mr-20"></i>
                        <span class="right-nav-text">Offers </span>
                    </div>
                    <div class="pull-right">
                        <i class="zmdi zmdi-caret-down"></i>
                    </div>
                    <div class="clearfix"></div>
                    </a>
                    <ul id="offers_dr" class="collapse collapse-level-1">

                    <li>
                        <a href="{{ route('admin.offers.create') }}">
                            <i class="zmdi zmdi-account-add mr-10"></i>
                            <span class="right-nav-text">New</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.offers.index') }}">
                            <i class="zmdi zmdi-accounts-add mr-10"></i>
                            <span class="right-nav-text">Manage</span>
                        </a>
                    </li>

                    </ul>
                </li>

                <li>
                    <a href="javascript:void(0);" data-toggle="collapse" data-target="#offerproducts_dr">
                    <div class="pull-left">
                        <i class="zmdi zmdi-collection-item mr-20"></i>
                        <span class="right-nav-text">Offer Products </span>
                    </div>
                    <div class="pull-right">
                        <i class="zmdi zmdi-caret-down"></i>
                    </div>
                    <div class="clearfix"></div>
                    </a>
                    <ul id="offerproducts_dr" class="collapse collapse-level-1">

                    <li>
                        <a href="{{ route('admin.offerproducts.create') }}">
                            <i class="zmdi zmdi-account-add mr-10"></i>
                            <span class="right-nav-text">New</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.offerproducts.index') }}">
                            <i class="zmdi zmdi-accounts-add mr-10"></i>
                            <span class="right-nav-text">Manage</span>
                        </a>
                    </li>

                    </ul>
                </li>

               {{-- <li>
                  <a href="javascript:void(0);" data-toggle="collapse" data-target="#settings_dr">
                     <div class="pull-left">
                        <i class="zmdi zmdi-accounts mr-20"></i>
                        <span class="right-nav-text">Settings </span>
                     </div>
                     <div class="pull-right">
                        <i class="zmdi zmdi-caret-down"></i>
                     </div>
                     <div class="clearfix"></div>
                  </a>
                  <ul id="settings_dr" class="collapse collapse-level-1">

                     <li>
                        <a href="{{ route('loansettings.index') }}">
                           <i class="zmdi zmdi-account-add mr-10"></i>
                           <span class="right-nav-text">Loan Settings</span>
                        </a>
                     </li>
                     <li>
                        <a href="{{ route('remindersettings.index') }}">
                           <i class="zmdi zmdi-account-add mr-10"></i>
                           <span class="right-nav-text">Reminder Settings</span>
                        </a>
                     </li>
                     <li>
                        <a href="#">
                           <i class="zmdi zmdi-accounts-add mr-10"></i>
                           <span class="right-nav-text">Other Settings</span>
                        </a>
                     </li>

                  </ul>
               </li> --}}

               {{-- <li>
                  <a href="javascript:void(0);" data-toggle="collapse" data-target="#myaccount_dr">
                     <div class="pull-left">
                        <i class="zmdi zmdi-reader mr-20"></i>
                        <span class="right-nav-text">My Account </span>
                     </div>
                     <div class="pull-right">
                        <i class="zmdi zmdi-caret-down"></i>
                     </div>
                     <div class="clearfix"></div>
                  </a>
                  <ul id="myaccount_dr" class="collapse collapse-level-1">

                     <li>
                        <a href="{{ route('myaccount.mpesab2cbalance') }}">
                           <i class="zmdi zmdi-account-add mr-10"></i>
                           <span class="right-nav-text">Mpesa B2C Balance</span>
                        </a>
                     </li>


                  </ul>
               </li> --}}

            </ul>
         </li>

      @endif



      <li><hr class="light-grey-hr mb-10"/></li>

      <li>
        <a href="javascript:void(0);" data-toggle="collapse" data-target="#accounts_dr">
           <div class="pull-left">
              <i class="zmdi zmdi-accounts mr-20"></i>
              <span class="right-nav-text">Accounts </span>
           </div>
           <div class="pull-right">
              <i class="zmdi zmdi-caret-down"></i>
           </div>
           <div class="clearfix"></div>
        </a>
        <ul id="accounts_dr" class="collapse collapse-level-1">

           <li>
              <a href="javascript:void(0);" data-toggle="collapse" data-target="#glaccountsdata_dr">
                 <div class="pull-left">
                    <i class="zmdi zmdi-accounts mr-20"></i>
                    <span class="right-nav-text">GL Accounts </span>
                 </div>
                 <div class="pull-right">
                    <i class="zmdi zmdi-caret-down"></i>
                 </div>
                 <div class="clearfix"></div>
              </a>
              <ul id="glaccountsdata_dr" class="collapse collapse-level-1">

                 <li>
                    <a href="{{ route('admin.manage.glaccounts.index') }}">
                       <i class="zmdi zmdi-account-add mr-10"></i>
                       <span class="right-nav-text">Manage GL Accts</span>
                    </a>
                 </li>
                 <li>
                    <a href="{{ route('admin.gl-accounts-history.index') }}">
                       <i class="zmdi zmdi-account-add mr-10"></i>
                       <span class="right-nav-text">GL Accts History</span>
                    </a>
                 </li>
                 <li>
                   <a href="{{ route('admin.gl-accounts-summary.index') }}">
                       <i class="zmdi zmdi-account-add mr-10"></i>
                       <span class="right-nav-text">GL Accts Summary</span>
                   </a>
                   </li>

              </ul>
           </li>

           <li>
              <a href="javascript:void(0);" data-toggle="collapse" data-target="#transfersdata_dr">
                 <div class="pull-left">
                    <i class="zmdi zmdi-accounts mr-20"></i>
                    <span class="right-nav-text">Transfers </span>
                 </div>
                 <div class="pull-right">
                    <i class="zmdi zmdi-caret-down"></i>
                 </div>
                 <div class="clearfix"></div>
              </a>
              <ul id="transfersdata_dr" class="collapse collapse-level-1">

                 <li>
                    <a href="{{ route('transfers.create') }}">
                       <i class="zmdi zmdi-account-add mr-10"></i>
                       <span class="right-nav-text">New</span>
                    </a>
                 </li>
                 <li>
                    <a href="{{ route('transfers.index') }}">
                       <i class="zmdi zmdi-accounts-add mr-10"></i>
                       <span class="right-nav-text">Manage</span>
                    </a>
                 </li>

              </ul>
           </li>

        </ul>
     </li>



      <li>
         <a href="javascript:void(0);" data-toggle="collapse" data-target="#orders_dr">
            <div class="pull-left">
               <i class="zmdi zmdi-shopping-cart mr-20"></i>
               <span class="right-nav-text">Orders </span>
            </div>
            <div class="pull-right">
               <i class="zmdi zmdi-caret-down"></i>
            </div>
            <div class="clearfix"></div>
         </a>
         <ul id="orders_dr" class="collapse collapse-level-1">

            <li>
               <a href="{{ route('admin.orders.create') }}">
                  <i class="zmdi zmdi-account-add mr-10"></i>
                  <span class="right-nav-text">New</span>
               </a>
            </li>
            <li>
               <a href="{{ route('admin.orders.index') }}">
                  <i class="zmdi zmdi-accounts-add mr-10"></i>
                  <span class="right-nav-text">Manage</span>
               </a>
            </li>

         </ul>
      </li>

      <li>
         <a href="javascript:void(0);" data-toggle="collapse" data-target="#cashout_dr">
            <div class="pull-left">
               <i class="zmdi zmdi-money mr-20"></i>
               <span class="right-nav-text">Cash Out </span>
            </div>
            <div class="pull-right">
               <i class="zmdi zmdi-caret-down"></i>
            </div>
            <div class="clearfix"></div>
         </a>
         <ul id="cashout_dr" class="collapse collapse-level-1">


            <li>
               <a href="{{ route('users.create') }}">
                  <i class="zmdi zmdi-account-add mr-10"></i>
                  <span class="right-nav-text">New</span>
               </a>
            </li>
            <li>
               <a href="{{ route('bulk-users.create') }}">
                  <i class="zmdi zmdi-accounts-add mr-10"></i>
                  <span class="right-nav-text">Manage</span>
               </a>
            </li>


         </ul>
      </li>

      <li><hr class="light-grey-hr mb-10"/></li>

      <li>
         <a href="javascript:void(0);" data-toggle="collapse" data-target="#sms_dr">
            <div class="pull-left">
               <i class="zmdi zmdi-smartphone mr-20"></i>
               <span class="right-nav-text">Alerts</span>
            </div>
            <div class="pull-right">
               <i class="zmdi zmdi-caret-down"></i>
            </div>
            <div class="clearfix"></div>
         </a>
         <ul id="sms_dr" class="collapse collapse-level-1 two-col-list">
            <li>
               <a href="javascript:void(0);" data-toggle="collapse" data-target="#bulksms_dr">
                  <div class="pull-left">
                     <span class="right-nav-text">Bulk SMS</span>
                  </div>
                  <div class="pull-right">
                     <i class="zmdi zmdi-caret-down"></i>
                  </div>
                  <div class="clearfix"></div>
               </a>
               <ul id="bulksms_dr" class="collapse collapse-level-1 two-col-list">
                  <li>
                     <a href="{{ route('smsoutbox.create') }}">Send SMS</a>
                  </li>
                  <li>
                     <a href="{{ route('scheduled-smsoutbox.index') }}">Scheduled SMS</a>
                  </li>
                  <li>
                     <a href="{{ route('smsoutbox.index') }}">My Outbox</a>
                  </li>
                  <!-- <li>
                     <a href="modals.php">Analytics</a>
                  </li> -->
               </ul>
            </li>
            <!-- <li>
               <a href="javascript:void(0);" data-toggle="collapse" data-target="#premsms_dr">
                  <div class="pull-left">
                     <span class="right-nav-text">Premium SMS</span>
                  </div>
                  <div class="pull-right">
                     <i class="zmdi zmdi-caret-down"></i>
                  </div>
                  <div class="clearfix"></div>
               </a>
               <ul id="premsms_dr" class="collapse collapse-level-1 two-col-list">
                  <li>
                     <a href="panels_wells.php">Outbox</a>
                  </li>
                  <li>
                     <a href="modals.php">Analytics</a>
                  </li>
               </ul>
            </li> -->
            <li>
               <a href="#">Inbox</a>
            </li>
            <!-- <li>
               <a href="notifications.php">Short Codes</a>
            </li> -->

         </ul>
      </li>

      <li>
         <a href="javascript:void(0);" data-toggle="collapse" data-target="#reports_dr">
            <div class="pull-left">
               <i class="zmdi zmdi-menu mr-20"></i>
               <span class="right-nav-text">Reports</span>
            </div>
            <div class="pull-right">
               <i class="zmdi zmdi-caret-down"></i>
            </div>
            <div class="clearfix"></div>
         </a>

         <ul id="reports_dr" class="collapse collapse-level-1 two-col-list">

            <li>
               <a href="{{ route('mpesa-incoming.index') }}">
                  <div class="pull-left">
                     <span class="right-nav-text">Manage Mpesa</span>
                  </div>
                  <div class="pull-right">
                  </div>
                  <div class="clearfix"></div>
               </a>
            </li>

            @if ((Auth::user()->hasRole('superadministrator')) ||
                  (
                     (Auth::user()->hasRole('administrator'))
                  )
                )
            <li>
               <a href="{{ route('payments.index') }}">
                  <div class="pull-left">
                     <span class="right-nav-text">Manage Payments</span>
                  </div>
                  <div class="pull-right">
                  </div>
                  <div class="clearfix"></div>
               </a>
            </li>
            @endif

         </ul>
      </li>

      <li>
         <a href="javascript:void(0);" data-toggle="collapse" data-target="#mpesa_dr">
            <div class="pull-left">
               <i class="zmdi zmdi-money mr-20"></i>
               <span class="right-nav-text">Mpesa</span>
            </div>
            <div class="pull-right">
               <i class="zmdi zmdi-caret-down"></i>
            </div>
            <div class="clearfix"></div>
         </a>

         <ul id="mpesa_dr" class="collapse collapse-level-1 two-col-list">

            <li>
               <a href="{{ route('mpesa-incoming.index') }}">
                  <div class="pull-left">
                     <span class="right-nav-text">Manage Mpesa</span>
                  </div>
                  <div class="pull-right">
                  </div>
                  <div class="clearfix"></div>
               </a>
            </li>

            @if ((Auth::user()->hasRole('superadministrator')) ||
                  (
                     (Auth::user()->hasRole('administrator'))
                  )
                )
            <li>
               <a href="{{ route('payments.index') }}">
                  <div class="pull-left">
                     <span class="right-nav-text">Manage Payments</span>
                  </div>
                  <div class="pull-right">
                  </div>
                  <div class="clearfix"></div>
               </a>
            </li>
            @endif

         </ul>
      </li>


      <li><hr class="light-grey-hr mb-10"/></li>

      <li>
         <a href="javascript:void(0);" data-toggle="collapse" data-target="#account_dr">
            <div class="pull-left">
               <i class="zmdi zmdi-account mr-20"></i>
               <span class="right-nav-text">My Account</span>
            </div>
            <div class="pull-right">
               <i class="zmdi zmdi-caret-down"></i>
            </div>
            <div class="clearfix"></div>
         </a>
         <ul id="account_dr" class="collapse collapse-level-1 two-col-list">
            <li>
               <a href="{{ route('user.profile') }}">
                  Profile
               </a>
            </li>
            {{-- <li>
               <a href="#" data-toggle="modal" data-target="#password-modal">Change Password</a>
            </li> --}}
            <li>
                <a href="{{ route('user.changepass') }}">Change Password</a>
             </li>

         </ul>
      </li>

      <li>
            <a href="{{ route('logout') }}"
                onclick="event.preventDefault();
                         document.getElementById('logout-form').submit();">
               <div class="pull-left">
                  <i class="zmdi zmdi-power mr-20"></i>
                  <span class="right-nav-text">Log Out</span>
               </div>

               <div class="clearfix"></div>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                {{ csrf_field() }}
            </form>

       </li>

   </ul>
</div>

