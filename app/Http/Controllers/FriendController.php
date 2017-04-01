<?php
namespace App\Http\Controllers;

use App\User;
use App\Friend;
use App\FriendRequest;
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

        if($friendRequest->save()){
            return redirect()->back()->with(['message' => 'Friend Request successfully send.']);
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

        if($friend->save()){
            $friendRequest->delete();
            return redirect()->route('dashboard');
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
