<?php

namespace App\Http\Controllers\Web;

use App\Entities\SiteContent;
use App\Entities\Country;
use App\Services\Contact\ContactStore;
use App\Services\SiteContent\SiteContentIndex;
use App\User;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Session;
use App\Http\Controllers\BaseController;
use App\Services\Subscriber\SubscriberStore;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class HomeController extends BaseController
{

    /**
     * Show the application home.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, SiteContentIndex $siteContentIndex)
    {

        $status_active = config('constants.status.active');
        $projects_category = config('constants.site_category.projects');
        $homeslider_category = config('constants.site_category.home_slider');
        $services_category = config('constants.site_category.services');
        $news_category = config('constants.site_category.news');
        $main_pillars_category = config('constants.site_category.main_pillars');

        $site_settings = app('site_settings');

        // get recent projects listing
        $recentProjectsDataArray = getSiteContent($projects_category, 3);
        $homeSlidersDataArray = getSiteContent($homeslider_category, 3, "order_id", "asc", 1, "homesliderimage");
        $servicesIconsDataArray = getSiteContent($services_category, 4, "site_content.id", "desc", $status_active, "icon");
        $servicesDataArray = getSiteContent($services_category, 4, "order_id", "asc", $status_active);

        $recentProjects = $recentProjectsDataArray['content'];
        $homeSliders = $homeSlidersDataArray['content'];
        $servicesIcons = $servicesIconsDataArray['content'];
        $servicesData = $servicesDataArray['content'];

        // get offers categories
        $club_cat_id = config('constants.establishments.club_cat_id');
        $rest_cat_id = config('constants.establishments.restaurant_cat_id');

        // get offers
        $eventOffers = getOffersFront('', 'event', 8, '', getStatusActive());
        $clubOffers = getOffersFront('', 'regular', 8, $club_cat_id, getStatusActive());
        $restaurantOffers = getOffersFront('', 'regular', 8, $rest_cat_id, getStatusActive());

        // diff
        /* $seconds = getSecondsToDate('2020-05-19 10:27:00');
        dd($seconds); */

        // dd("home eventOffers ", $eventOffers);

        return view('_web.home', compact('homeSliders', 'eventOffers', 'clubOffers', 'restaurantOffers'));

    }

    // show about page
    public function aboutus()
    {

        $status_active = config('constants.status.active');
        $aboutus_category = config('constants.site_category.about_us');
        $core_values_category = config('constants.site_category.core_values_icons');

        //get recent projects listing
        $aboutusDataArray = getSiteContent($aboutus_category, 1);
        $coreValuesIconsArray = getSiteContent($core_values_category, 8, "site_content.id", "desc", $status_active, "icon");

        $aboutusData = $aboutusDataArray['content']->first();
        $aboutusImages = $aboutusDataArray['images']->first();
        $coreValuesIcons = $coreValuesIconsArray['content'];

        return view('aboutus', compact('aboutusData', 'aboutusImages', 'coreValuesIcons'));

    }

    // show ecitizen page
    public function account()
    {

        $user = auth()->user();

        return view('profile.index', compact('user'));

    }

    // show careers page
    public function careers()
    {

        $status_active = config('constants.status.active');
        $aboutus_category = config('constants.site_category.about_us');
        $core_values_category = config('constants.site_category.core_values_icons');

        //get recent projects listing
        $aboutusDataArray = getSiteContent($aboutus_category, 1);
        $coreValuesIconsArray = getSiteContent($core_values_category, 8, "site_content.id", "desc", $status_active, "icon");

        $aboutusData = $aboutusDataArray['content']->first();
        $aboutusImages = $aboutusDataArray['images']->first();
        $coreValuesIcons = $coreValuesIconsArray['content'];

        return view('careers', compact('aboutusData', 'aboutusImages', 'coreValuesIcons'));

    }

    public function contacts()
    {

        $countries = Country::all();

        return view('_web.contacts', compact('countries'));

    }

    public function contactsStore(Request $request, ContactStore $contactStore)
    {

        $rules = [
            'name' => 'required',
            'subject' => 'required',
            'phone' => 'required|phone:KE',
            'message' => 'required',
        ];

        $payload = app('request')->only('name', 'subject', 'phone', 'message');

        $validator = app('validator')->make($payload, $rules);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator->errors());
        }

        //create item
        try {
            $new_contact = $contactStore->createItem($request->all());
            $new_contact = json_decode($new_contact);
            $result_message = $new_contact->message;
            //dd($result_message);

            $new_contact = $result_message->message;
            Session::flash('success', 'Your message has been successfully sent');
            return redirect()->route('contactus');

        } catch(\Exception $e) {

            $error_message = $e->getMessage();
            Session::flash('error', $error_message);
            return redirect()->back()->withInput()->withErrors($error_message);

        }

    }


    // create a new subscriber
    public function subscriberStore(Request $request, SubscriberStore $subscriberStore)
    {

        $rules = [
            'email' => 'required|email',
        ];

        //dd($request);

        $payload = app('request')->only('email');

        $validator = app('validator')->make($payload, $rules);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator->errors());
        }

        //create item
        $new_contact = $subscriberStore->createItem($request->all());
        $new_contact = json_decode($new_contact);
        $result_message = $new_contact->message;
        // dd($new_contact);

        if (!$new_contact->error) {
            $new_contact = $result_message->message;
            Session::flash('success', 'Your message has been successfully sent');
            return redirect()->back();
        } else {
            Session::flash('error', $result_message->message);
            return redirect()->back()->withInput()->withErrors($result_message->message);
        }

    }

    public function projects(Request $request, SiteContentIndex $siteContentIndex)
    {

        $status_active = config('constants.status.active');
        $projects_category = config('constants.site_category.projects');
        $limit = 4;
        if ($request->limit) {
            $limit = $request->limit;
        }
        $request->merge([
            'limit' => $limit,
            'status' => $status_active,
            'category' => $projects_category
        ]);

        $servicesData = $siteContentIndex->getData($request);

        return view('projects', compact('servicesData'));

    }

    public function showProject($id)
    {

        $status_active = config('constants.status.active');
        $projects_category = config('constants.site_category.projects');

        //get item
        $servicesItemDataArray = getSiteContentItem($projects_category, $id);
        $servicesDataArray = getSiteContent($projects_category, 0, "site_content.id", "desc", $status_active);

        $servicesItemData = $servicesItemDataArray['content'];
        $servicesItemImages = $servicesItemDataArray['images'];

        $servicesData = $servicesDataArray['content'];

        //dd($servicesDataArray, $servicesItemImages);

        return view('projects_show', compact('servicesItemData', 'servicesItemImages', 'servicesData'));

    }


}
