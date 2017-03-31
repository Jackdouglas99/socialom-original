<?php
namespace App\Http\Controllers;

use App\User;
use App\Friend;
use App\FriendRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FriendController extends Controller
{
    public function postAddFriend(Request $request)
    {
        $uid1 = Auth::user()->id;
        $uid2 = $request['uid2'];

        $friendRequest = new FriendRequest();
        $friendRequest->uid1 = $uid1;
        $friendRequest->uid2 = $uid2;

        $friendRequest->save();
        return redirect()->route('dashboard');
    }
}
