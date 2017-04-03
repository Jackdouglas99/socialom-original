<?php
namespace App\Http\Controllers;

use App\Post;
use App\User;
use App\Like;
use App\Comment;
use App\Friend;
use App\FriendRequest;
use App\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function getDashboard()
    {
        $posts = Post::orderBy('updated_at', 'desc')->get();
        return view('dashboard', ['posts' => $posts]);
    }

    public function getProfile($username)
    {
        $user = User::where('username', $username)->first();
        $posts = Post::where('user_id', $user->id)->orderBy('updated_at', 'desc')->get();
        $friendRequest = FriendRequest::where('uid1', $user->id)->orwhere('uid2', $user->id)->get();
        $friends = Friend::where('uid1', $user->id)->where('uid2', Auth::user()->id)->orwhere('uid2', $user->id)->where('uid1', Auth::user()->id)->get();
        return view('profile', ['posts' => $posts, 'user' => $user, 'friendRequest' => $friendRequest, 'friends' => $friends]);
    }

    public function postCreatePost(Request $request)
    {
        $this->validate($request, [
            'body' => 'required|max:1000'
        ]);
        $post = new Post();
        $post->body = $request['body'];
        $message = "There was an error.";
        if($request->user()->posts()->save($post)){
            $message = "Post successfully created";
        }
        return redirect()->route('dashboard')->with(['message' => $message]);
    }

    public function getDeletePost($post_id)
    {
        $post = Post::where('id', $post_id)->first();
        if($post->user->id =! Auth::user()){
            return redirect()->route('dashboard');
        }
        $post->delete();
        return redirect()->back()->with(['message' => 'Successfully deleted!']);
    }

    public function postEditPost(Request $request)
    {
        $this->validate($request, [
            'body' => 'required|max:1000'
        ]);
        $post = Post::find($request['postId']);
        $post->body = $request['body'];
        $post->update();
        return response()->json(['new_body' => $post->body], 200);
    }

    public function postLikePost($post_id)
    {
        // Like setup
        $like = new Like();
        $like->user_id = Auth::user()->id;
        $like->post_id = $post_id;
        $like->like = '1';

        // Notification setup
        $post = Post::where('id', $post_id)->first();
        $notif = new Notification();
        $notif->user_id = Auth::user()->id;
        $notif->to = $post->user_id;
        $notif->type = 'like';
        $notif->data = $post_id;

        if($like->save()){
            if($post->user_id != Auth::user()->id) {
                if ($notif->save()) {
                    return redirect()->back();
                } else {
                    return redirect()->back()->with(['message' => 'There was an error please try again later']);
                }
            }else{
                return redirect()->back();
            }
        }else{
            return redirect()->back()->with(['message' => 'There was an error please try again later']);
        }
    }

    public function postUnLikePost($post_id)
    {
        $like = Like::where('post_id', $post_id)->where('user_id', Auth::user()->id)->first();
        if($like->delete()){
            return redirect()->back();
        }else{
            return redirect()->back()->with(['message' => 'There was an error please try again later']);
        }
    }

    public function postAddComment(Request $request)
    {
        $this->validate($request, [
            'comment' => 'required|max:1000'
        ]);
        $comment = new Comment();
        $comment->user_id = Auth::user()->id;
        $comment->post_id = $request['post_id'];
        $comment->content = $request['comment'];

        // Notification setup
        $post = Post::where('id', $request['post_id'])->first();
        $notif = new Notification();
        $notif->user_id = Auth::user()->id;
        $notif->to = $post->user_id;
        $notif->type = 'comment';
        $notif->data = $request['post_id'];

        if($request->user()->comment()->save($comment)) {
            if ($post->user_id != Auth::user()->id) {
                if ($notif->save()) {
                    return redirect()->back()->with(['message' => 'Comment successfully created']);
                } else {
                    return redirect()->back()->with(['message' => 'There was an error please try again later']);
                }
            } else {
                return redirect()->back();
            }
        }

    }

    public function getViewPost($post_id)
    {
        $post = Post::where('id', $post_id)->first();
        return view('post', ['post' => $post]);
    }
}
