<?php

namespace App\Http\Controllers\Web\Images;

use App\Company;
use App\Entities\Image;
use App\Http\Controllers\Controller;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Session;

class ImageController extends Controller
{
    
    /**
     * @var state
     */
    protected $model;

    /**
     * ImageController constructor.
     *
     * @param Image $model
     */
    public function __construct(Image $model)
    {
        $this->model = $model;

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function resizeImage()
    {
        return view('resizeImage');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function resizeImagePost(Request $request)
    {
        dd($request);
        $this->validate($request, [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $image = $request->file('image');
        $input['imagename'] = time().'.'.$image->getClientOriginalExtension();
     
   
        $destinationPath = public_path('/images/uploads/thumbnail');
        $img = Image::make($image->getRealPath());
        $img->resize(100, 100, function ($constraint) {
            $constraint->aspectRatio();
        })->save($destinationPath.'/'.$input['imagename']);

        $destinationPath = public_path('/images/uploads');
        $image->move($destinationPath, $input['imagename']);

        $this->postImage->add($input);

        return back()
            ->with('success','Image Upload successful')
            ->with('imageName', $input['imagename']);
    }

    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }

}
