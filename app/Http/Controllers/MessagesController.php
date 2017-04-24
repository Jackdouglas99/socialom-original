<?php
namespace App\Http\Controllers;

use App\User;
use App\Notification;
use App\Chat;
use App\Message;
use Carbon\Carbon;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessagesController extends Controller
{
    public function getIndex()
    {
        $chats = Chat::where('user_id_to', Auth::user()->id)->orWhere('user_id_from', Auth::user()->id)->orderBy('updated_at', 'desc')->get();
        return view('messages.index')->with(['chats' => $chats]);
    }

    public function getChat($chat_id)
    {
        $chat = Chat::where('id', $chat_id)->first();
        $messages = Message::where('chat_id', $chat_id)->orderBy('updated_at', 'asc')->get();
        return view('messages.chat')->with(['chat' => $chat, 'messages' => $messages]);
    }

    public function postSendChat($chat_id, Request $request)
    {
        $this->validate($request, [
            'message' => 'required|max:1000'
        ]);
        $message = new Message();
        $message->chat_id = $chat_id;
        $message->user_id = Auth::user()->id;
        $message->message = $request['message'];

        $notif = new Notification();
        $notif->user_id = Auth::user()->id;
        if(Chat::where('id', $chat_id)->first()->user_id_to == Auth::user()->id){
            $notif->to = Chat::where('id', $chat_id)->first()->user_id_from;
        }elseif(Chat::where('id', $chat_id)->first()->user_id_from == Auth::user()->id){
            $notif->to = Chat::where('id', $chat_id)->first()->user_id_to;
        }
        $notif->type = 'message.added';
        $notif->data = $chat_id;

        if($message->save()){
            if($notif->save()) {
                return redirect()->route('messages.get.chat', $chat_id);
            }else{
                return redirect()->route('messages.get.chat', $chat_id)->with(['message' => 'The message was sent but a notification could not be sent.']);
            }
        }else{
            return redirect()->route('messages.get.chat', $chat_id)->with(['message' => 'Error could not send message']);
        }
    }

    public function getNewChat($username = null)
    {
        if($username){
            return view('messages.new-message')->with(['username' => $username]);
        }else{
            return view('messages.new-message');
        }

    }
    public function postNewChat(Request $request)
    {
        $this->validate($request, [
            'username' => 'required',
            'message' => 'required|max:1000'
        ]);

        $user = User::where('username', $request['username'])->first();
        if(!count($user)){
            return redirect()->route('dashboard')->with(['message' => 'Profile dose not exist.']);
        }

        $chat = new Chat();
        $chat->user_id_to = $user->id;
        $chat->user_id_from = Auth::user()->id;

        if($chat->save()){
            $message = new Message();
            $message->chat_id = $chat->id;
            $message->user_id = Auth::user()->id;
            $message->message = $request['message'];

            $notif = new Notification();
            $notif->user_id = Auth::user()->id;
            $notif->to = $user->id;
            $notif->type = 'message.added';
            $notif->data = $chat->id;
            if($message->save()){
                if($notif->save()){
                    return redirect()->route('messages.get.chat', $chat->id);
                }else{
                    return redirect()->route('messages.get.chat')->with(['message' => 'Error: The chat was create and the message was sent but no notification could be sent.']);
                }
            }else{
                return redirect()->route('messages.new.chat')->with(['message' => 'Error: could not send message.']);
            }
        }else{
            return redirect()->route('messages.new')->with(['message' => 'Error: could not start chat session']);
        }
    }
}