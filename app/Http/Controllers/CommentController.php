<?php

namespace App\Http\Controllers;

use App\Entities\Comment;
use Illuminate\Http\Request;
use App\Http\Requests;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $post_id = $request->post_id;
        $finalData = Comment::where('post_id', $post_id)
            ->orderBy('created_at', 'desc')
            ->get();

        return response(['data' => $finalData], 200);
        
    }

    public function create(Request $request)
    {
        
        $this->validate($request,[
                'post_id' => 'required',
                'content' => 'required'
            ]);

        $comment = Comment::create([
                        'content' => $request->content,
                        'post_id' => $request->post_id,
                        'user_id' => $request->user()->id,
                        'user_agent' => getUserAgent(),
                        'ip' => getIp()
                  ]);

        $comment->save();

        $finalData = Comment::where('id', $comment->id)->first();

        //event(new ChatMessage($chat));

        return response(['data' => $finalData], 201);

    }

    //get post comments
    public function getPostComments($post_id)
    {
        
        $finalData = Comment::where('post_id', $post_id)
            ->orderBy('created_at', 'desc')
            ->get();

        return response(['data' => $finalData], 200);

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
        
        $comment = Comment::find($id);
        
        $this->validate($request,[
                'id' => 'required',
                'content' => 'required'
            ]);

        $comment->content = $request->content;
        $comment->user_agent = getUserAgent();
        $comment->ip = getIp();

        $comment->save();

        $finalData = Comment::where('id', $comment->id)->first();

        //event(new ChatMessage($chat));

        return response(['data' => $finalData], 201);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = Comment::find($id);
        $item->delete();

        return response(['data' => ""], 200);
    }

}
