<?php
namespace App\Http\Controllers;

use App\Post;
use App\Report;
use App\Comment;
use App\Like;
use App\Notification;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function postAddReport($post_id, Request $request)
    {
        $report = new Report();
        $report->post_id = $post_id;
        $report->reporter = Auth::user()->id;
        $report->reported = Post::where('id', $post_id)->first()->user_id;
        $report->reason = $request['report'];
        $report->status = '0';
        if($report->save()){
            $message = "Report successfully added.";
        }else{
            $message = "There was an error.";
        }
        return redirect()->route('dashboard')->with(['message' => $message]);
    }
    public function postReportAdmin($report_id, Request $request)
    {
        $report = Report::Find($report_id);

        $report->status = $request['status'];



        if($report->update()){
            if($request['status'] == 1){
                $post_id = Report::where('id', $report_id)->first()->post_id;
                $post = Post::where('id', $post_id)->first();
                Comment::where('post_id', $post_id)->delete();
                Like::where('post_id', $post_id)->delete();
                $post->delete();
                return redirect()->route('admin.reports')->with(['message' => 'Post successfully deleted & Report Updated!']);
            }else {
                return redirect()->route('admin.report', $report_id)->with(['message', 'Report updated']);
            }
        }else{
            return redirect()->route('admin.report', $report_id)->with(['message', 'Error updating report']);
        }

    }
}