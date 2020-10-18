<?php

namespace App\Http\Controllers;

use App\Entities\Like;
use Illuminate\Http\Request;
use App\Http\Requests;

class LikeController extends Controller
{

    /**
     * Display all user likes
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        $authUserId = $request->user()->id;

        $finalData = Like::where('user_id', $authUserId)
            ->orderBy('created_at', 'desc')
            ->get();

        return response(['data' => $finalData], 200);

    }


    /**
     * Store a new like for post
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

        $this->validate($request,[
                'post_id' => 'required'
            ]);

        $like = Like::create([
                        'post_id' => $request->post_id,
                        'user_id' => $request->user()->id,
                        //'user_id' => 1,
                        'user_agent' => getUserAgent(),
                        'ip' => getIp()
                  ]);

        $like->save();

        $finalData = Like::where('post_id', $like->post_id)
            ->where('user_id', $request->user()->id)
            ->first();

        return response(['data' => $finalData], 201);

    }

	//get post likes
    public function getPostLikes($post_id)
    {
        
        $finalData = Like::where('post_id', $post_id)
            ->orderBy('created_at', 'desc')
            ->get();

        return response(['data' => $finalData], 200);

    }

    /*delete like*/
    public function destroy($post_id)
    {
        $userId = auth()->user()->id;
        $item = Like::where('post_id', $post_id)
                ->where('user_id', $userId);
                //->first();
        if ($item) {
            $item->delete();
        }

        return response(['data' => ""], 200);
    }

}
