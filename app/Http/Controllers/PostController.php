<?php

namespace App\Http\Controllers;

use App\Entities\Post;
use Illuminate\Http\Request;
use App\Http\Requests;

class PostController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    /*get posts*/
    public function index(Request $request)
    {
        
        $authUserId = $request->user()->id;

        $finalData = Post::
            with('comments')
            ->with('user')
            ->with('likes')
            ->where('user_id', $authUserId)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return response(['data' => $finalData], 200);

    }

    /*get user posts*/
    public function getUserPosts($id){

        $data = Post::
            with('comments')
            ->with('likes')
            ->where('user_id', $id)
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return response(['data' => $data], 200);

    }

    /*get wall posts*/
    public function getWallPosts($wall_id){

        $data = Post::
            with('comments')
            ->with('likes')
            ->where('wall_id', $wall_id)
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return response(['data' => $data], 200);

    }

    /*get user's current status*/
    /*public function getStatus(Request $request)
    {
        
        $userId = $request->user()->id;

        $finalData = Post::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->first();
            ->get();

        return response(['data' => $finalData], 200);

    }*/

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

        $data = [
            //'user_id' => $request->user()->id,
            'user_id' => '1',
            'user_agent' => getUserAgent(),
            'ip' => getIp(),
            'host' => getHost(),
            'content' => $request->content,
            'wall_id' => $request->wall_id
        ];

        //return $data;

        $post = Post::create($data);

        $finalData = Post::where('id', $post->id)
                ->with('user')
                ->first();

        //event(new ChatMessage($chat));

        return response(['data' => $finalData], 201);
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
