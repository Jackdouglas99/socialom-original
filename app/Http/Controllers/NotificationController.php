<?php
namespace App\Http\Controllers;

use App\User;
use App\Notification;
use Carbon\Carbon;

use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function getReadNotification($notif_id)
    {
        $notif = Notification::find($notif_id);

        $time = Carbon::now()->toDateTimeString();
        if($notif->type == "like"){
            $notif->read_at = $time;
            if($notif->update()) {
                return redirect()->route('view.post', $notif->data);
            }
        }elseif($notif->type == "fRequest"){
            $notif->read_at = $time;
            if($notif->update()) {
                return redirect()->route('profile', User::where('id', $notif->user_id)->first()->username);
            }
        }elseif($notif->type == "fRequestAccept"){
            $notif->read_at = $time;
            if($notif->update()) {
                return redirect()->route('profile', User::where('id', $notif->user_id)->first()->username);
            }
        }elseif($notif->type == "comment"){
            $notif->read_at = $time;
            if($notif->update()) {
                return redirect()->route('view.post', $notif->data);
            }
        }
    }
}