<?php
namespace App\Http\Controllers;

use App\User;
use App\Post;
use App\Comment;
use App\Like;
use App\Report;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function getDashboard()
    {
        $post_count = count(Post::orderBy('updated_at', 'desc')->get());
        $user_count = count(User::where('suspended', '0')->get());
        $comment_count = count(Comment::orderBy('updated_at', 'desc')->get());
        $report_count = count(Report::orderBy('status', '0')->get());


        $posts_recent = Post::orderBy('created_at', 'desc')->limit(5)->get();
        $comments_recent = Comment::orderBy('created_at', 'desc')->limit(5)->get();
        $users_recent = User::orderBy('created_at', 'desc')->limit(5)->get();
        return view('admin.view')->with([
            'post_count' => $post_count,
            'user_count' => $user_count,
            'comment_count' => $comment_count,
            'report_count' => $report_count,
            'posts_recent' => $posts_recent,
            'comments_recent' => $comments_recent,
            'users_recent' => $users_recent
        ]);
    }
    public function postUpdateUserA($user_id, Request $request)
    {
        $user = User::Find($user_id);

        if(isset($request['suspend'])){
            $user->suspended = "1";
        }elseif(isset($request['unsuspend'])){
            $user->suspended = "0";
        }

        if($user->save()){
            if(isset($request['suspend'])){
                return redirect()->route('admin.user', $user_id)->with('message', 'User has been suspended');
            }elseif(isset($request['unsuspend'])){
                return redirect()->route('admin.user', $user_id)->with('message', 'User has been un-suspended');
            }
        }else{
            return redirect()->back->with(['message', 'There has been an error!']);
        }
    }
    public function postUpdateUserSA($user_id, Request $request)
    {
        $user = User::Find($user_id);

        if(Auth::user()->role == 2){
            $user->role = $request['role'];
            if($user->save()){
                return redirect()->route('admin.user', $user_id)->with('message', 'Account has been successfully saved.');
            }
        }
    }

    // Get groups
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
    public function getReports()
    {
        $reports = Report::orderBy('created_at', 'desc')->get();
        return view('admin.reports', [
            'reports' => $reports
        ]);
    }

    // Get single items
    public function getUser($user_id)
    {
        $user = User::where('id', $user_id)->first();
        if($user->id == Auth::user()->id){
            return redirect()->route('admin.dashboard')->with('message', 'Sorry. You cannot view your own account.');
        }
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
    public function getReport($report_id)
    {
        $report = Report::where('id', $report_id)->first();
        return view('admin.report', [
            'report' => $report
        ]);
    }


}
