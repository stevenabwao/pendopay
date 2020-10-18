<?php

namespace App\Services\SiteContent;

use App\Entities\SiteContent;
use App\Entities\Category;
use Carbon\Carbon;
use IntImage;
use Dingo\Api\Exception\StoreResourceFailedException;
use Dingo\Api\Routing\Helpers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SiteContentStore
{

    use Helpers;

    public function createItem($request) {

        DB::beginTransaction();

            $title = $request->title;

            $permalink = getStrSlug($title);

            $request->merge([
                'permalink' => $permalink
            ]);

            if ($request->hasFile('item_image')) {

                //get filename without extension
                $filenameWithExt = $request->file('item_image')->getClientOriginalName();

                //get filename only
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);

                //format filename
                $filename = str_replace('-', '_', getStrSlug($filename));

                //get file extension
                $extension = $request->file('item_image')->getClientOriginalExtension();

                //filename to store
                $filenameToStore = $filename . '_' . time() . '.' . $extension;

                //upload image
                $path = $request->file('item_image')->storeAs('public/images', $filenameToStore);
                $thumbpath = $request->file('item_image')->storeAs('public/images/thumbs', $filenameToStore);

                //get site settings
                $site_settings = app('site_settings');

                $thumb_width = $site_settings['image_thumbnail_width'];
                $thumb_height = $site_settings['image_thumbnail_height'];
                $image_width = $site_settings['image_width'];
                $image_height = $site_settings['image_height'];
                $home_slider_image_width = $site_settings['home_slider_image_width'];
                $home_slider_image_height = $site_settings['home_slider_image_height'];

                $cat_home_slider = config('constants.site_category.home_slider');

                if ($request->category_id == $cat_home_slider) {
                    $the_width = $home_slider_image_width;
                    $the_height = $home_slider_image_height;
                } else {
                    $the_width = $image_width;
                    $the_height = $image_height;
                }

                //resize image
                $imagepath = public_path('storage/images/' . $filenameToStore);
                $img = IntImage::make($imagepath)->fit($the_width, $the_height, function($constraint) {
                    $constraint->upsize();
                });
                $img->save($imagepath);

                //resize thumb
                $thumbnailpath = public_path('storage/images/thumbs/' . $filenameToStore);
                $thumbimg = IntImage::make($thumbnailpath)->fit($thumb_width, $thumb_height, function($constraint) {
                     $constraint->upsize();
                });
                $thumbimg->save($thumbnailpath);

            }

            //start create new site content
            try {

                $new_site_content = new SiteContent();

                //dd($request->all());

                $result = $new_site_content->create($request->all());

                if ($request->hasFile('item_image')) {

                    //get category data
                    $category_data = Category::find($result->category_id);

                    //dd($result, $category_data);

                    //save article image
                    $category_id = $result->category_id;
                    $caption = $title;
                    $thumb_img = "";
                    $section = "normal";
                    $main_img = 'n';
                    $imagetable_type = $category_data->code;
                    $imagetable_id = $result->id;
                    $full_img = "images/" . $filenameToStore;

                    saveArticleImage($caption, $category_id, $imagetable_id, $imagetable_type, $section, $full_img, $thumb_img, $main_img);

                }

                $response["message"] = $result;

            } catch(\Exception $e) {

                DB::rollback();
                $message = $e->getMessage();
                $response["message"] = $message;
                return show_json_error($response);

            }
            //end create new site content


        return show_json_success($response);

    }

}
