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

        $notif = new Notification();
        $notif->user_id = Auth::user()->id;
        $notif->to = Post::where('id', $post_id)->first()->user_id;
        $notif->type = 'post.reported';
        $notif->data = $post_id;

        if($report->save()){
            if($notif->save()) {
                $message = "Report successfully added.";
            }else{
                $message= "There was an error.";
            }
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

                $reporter_notif = new Notification();
                $reporter_notif->user_id = Auth::user()->id;
                $reporter_notif->to = $report->reporter;
                $reporter_notif->type = 'reporter.post.deleted';

                $reported_notif = new Notification();
                $reported_notif->user_id = Auth::user()->id;
                $reported_notif->to = $report->reported;
                $reported_notif->type = 'reported.post.deleted';

                Comment::where('post_id', $post_id)->delete();
                Like::where('post_id', $post_id)->delete();
                $post->delete();
                if($reported_notif->save()){
                    if($reporter_notif->save()){
                        return redirect()->route('admin.reports')->with(['message' => 'Post successfully deleted & Report Updated!']);
                    }else{
                        return redirect()->route('admin.report', $report_id)->with(['message', 'Error updating report']);
                    }
                }else{
                    return redirect()->route('admin.report', $report_id)->with(['message', 'Error updating report']);
                }
            }else {
                return redirect()->route('admin.report', $report_id)->with(['message', 'Report has been set as spam.']);
            }
        }else{
            return redirect()->route('admin.report', $report_id)->with(['message', 'Error updating report']);
        }

    }
}