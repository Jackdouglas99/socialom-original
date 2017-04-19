<?php
namespace App\Http\Controllers;

use App\User;
use App\Friend;
use App\FriendRequest;
use App\Notification;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FriendController extends Controller
{
    public function postSendRequest(Request $request)
    {
        $uid1 = Auth::user()->id;
        $uid2 = $request['uid2'];

        $friendRequest = new FriendRequest();
        $friendRequest->uid1 = $uid1;
        $friendRequest->uid2 = $uid2;

        // Notification setup
        $notif = new Notification();
        $notif->user_id = Auth::user()->id;
        $notif->to = $uid2;
        $notif->type = 'fRequest';

        if($friendRequest->save()){
            if ($notif->save()) {
                return redirect()->back()->with(['message' => 'Friend Request successfully send.']);
            }else{
                return redirect()->back()->with(['message' => 'There was an error. Please try again later']);
            }
        }else{
            return redirect()->back()->with(['message' => 'Could not send friend request. Please try again later']);
        }
    }
    public function postCancelRequest(Request $request)
    {
        $frid = $request['frid'];

        $friendRequest = FriendRequest::where('id', $frid)->first();


        if($friendRequest->delete()){
            return redirect()->back()->with(['message' => 'Friend Request successfully cancel.']);
        }else{
            return redirect()->back()->with(['message' => 'Could not cancel friend request. Please try again later']);
        }
    }
    public function getAcceptRequest($frid)
    {
        $friendRequest = FriendRequest::where('id', $frid)->first();
        $friend = new Friend();
        $friend->uid1 = $friendRequest->uid1;
        $friend->uid2 = $friendRequest->uid2;

        // Notification setup
        $notif = new Notification();
        $notif->user_id = $friendRequest->uid2;
        $notif->to = $friendRequest->uid1;
        $notif->type = 'fRequestAccept';

        if($friend->save()){
            if($notif->save()) {
                $friendRequest->delete();
                return redirect()->route('dashboard');
            }else{
                return redirect()->route('dashboard')->with(['message' => 'There was a problem sending the notification.']);
            }
        }else{
            $message = "Could not accept request. Please try again later";
            return redirect()->back()->with(['message' => $message]);
        }


    }
    public function getDeclineRequest($frid)
    {
        $friendRequest = FriendRequest::where('id', $frid)->first();

        if($friendRequest->delete()){
            return redirect()->back()->with(['message' => 'Friend Request successfully declined.']);
        }else{
            return redirect()->back()->with(['message' => 'Could not decline friend request. Please try again later']);
        }
    }
}
