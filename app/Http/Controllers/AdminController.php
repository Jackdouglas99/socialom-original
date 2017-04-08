<?php
namespace App\Http\Controllers;

use App\User;
use App\Post;
use App\Comment;
use App\Like;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function getDashboard()
    {
        $post_count = count(Post::orderBy('updated_at', 'desc')->get());
        $user_count = count(User::where('suspended', '0')->get());
        $comment_count = count(Comment::orderBy('updated_at', 'desc')->get());
        $like_count = count(Like::where('like', '1')->get());

        $posts_recent = Post::orderBy('created_at', 'desc')->limit(5)->get();
        $comments_recent = Comment::orderBy('created_at', 'desc')->limit(5)->get();
        $users_recent = User::orderBy('created_at', 'desc')->limit(5)->get();
        return view('admin.view')->with([
            'post_count' => $post_count,
            'user_count' => $user_count,
            'comment_count' => $comment_count,
            'like_count' => $like_count,
            'posts_recent' => $posts_recent,
            'comments_recent' => $comments_recent,
            'users_recent' => $users_recent
        ]);
    }

    public function getUsers()
    {
        $users = User::orderBy('username', 'desc')->get();
        return view('admin.users')->with([
            'users' => $users
        ]);
    }

    public function getPosts()
    {
        $posts = Post::orderBy('updated_at', 'desc')->get();
        return view('admin.posts')->with([
            'posts' => $posts
        ]);
    }

    public function getComments()
    {
        $comments = Comment::orderBy('created_at', 'desc')->get();
        return view('admin.comments', [
            'comments' => $comments
        ]);
    }

    public function getUser($user_id)
    {
        $user = User::where('id', $user_id)->first();
        return view('admin.user', [
            'user' => $user
        ]);
    }

    public function getPost($post_id)
    {
        $post = Post::where('id', $post_id)->first();
        return view('admin.post', [
            'post' => $post
        ]);
    }

    public function getComment($comment_id)
    {
        $comment = Comment::where('id', $comment_id)->first();
        return view('admin.comment', [
            'comment' => $comment
        ]);
    }


}
