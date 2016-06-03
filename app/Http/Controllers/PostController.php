<?php

namespace App\Http\Controllers;

use App\Like;
use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function getDashboard(){
        $posts=Post::orderby('id','DESC')->get();

        return view('dashboard',['posts'=>$posts]);
    }

    public function getDeletePost($post_id){
        $post=Post::where('id',$post_id)->first();
        if(Auth::user()!=$post->user){
            return redirect()->back();
        }
        $post->delete();
        return redirect()->route('dashboard')->with(['message'=>'Succesfully Deleted!']);

    }

    public function postCreatePost(Request $request){
        $this->validate($request,[
            'body'=>'required|max:1000'
        ]);

        $post=new Post();
        $post->body=$request['body'];
        //This will save the current post with a relation to the current user
        $message='We are sorry but your ideas couldn`t be shared!';
        if($request->user()->posts()->save($post)){
            $message='You shared something marvelous with the world!';
        }
        return redirect()->route('dashboard')->with(['message'=>$message]);
    }

    public function postEditPost(Request $request){
        $this->validate($request,[
            'body'=>'required'
        ]);

        $post=Post::find($request['postId']);
        if(Auth::user()!=$post->user){
            return redirect()->back();
        }
        $post->body=$request['body'];
        $post->update();
        return response()->json(['new_body'=>$post->body],200);
    }
    public function postLikePost(Request $request){
        $post_id=$request['postId'];
        $is_like=$request['isLike'] ==='true'? true:false;
        $update=false;
        $post=Post::find($post_id);
        if(!$post){
            return null;
        }
        $user= Auth::user();
        $like= $user->likes()->where('post_id',$post_id)->first();
        if($like){
            $liked=$like->like;
            $update=true;
            if($liked==$is_like){
                $like->delete();
                return null;
            }
        }
        else{
            $like = new Like();
        }
        $like->like=$is_like;
        $like->user_id=$user->id;
        $like->post_id=$post_id;
        if($update){
            $like->update();
        }
        else{
            $like->save();
        }
        return null;
    }
}
