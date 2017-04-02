<?php
namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function postSignUp(Request $request)
    {
        $this->validate($request, [
            'username' => 'required|max:50|unique:users',
            'email' => 'required|email|unique:users',
            'first_name' => 'required|max:50',
            'last_name' => 'required|max:100',
            'password' => 'required|min:4',
            'birth_day' => 'required'
        ]);
        $username = $request['username'];
        $first_name = $request['first_name'];
        $last_name = $request['last_name'];
        $email = $request['email'];
        $password = bcrypt($request['password']);
        $gender = $request['gender'];
        $birth_day = $request['birth_day'];

        $user = new User();
        $user->username = $username;
        $user->first_name = $first_name;
        $user->last_name = $last_name;
        $user->email = $email;
        $user->password = $password;
        $user->gender = $gender;
        $user->birth_day = $birth_day;

        $user->save();
        Auth::login($user);

        return redirect()->route('dashboard');

    }

    public function postSignIn(Request $request)
    {
        $this->validate($request, [
            'email1' => 'required|email',
            'password1' => 'required',
        ]);
        if(Auth::attempt(['email' => $request['email1'], 'password' => $request['password1']])){
            return redirect()->route('dashboard');
        }
        return redirect()->back()->with(['message' => 'Incorrect email address or password']);
    }
    public function getLogout()
    {
        Auth::logout();

        return redirect()->route('home');
    }

    public function getAccount()
    {
        return view('account', ['user' => Auth::user()]);
    }

    public function postUpdateAccount(Request $request)
    {
        $this->validate($request, [
            'username' => 'required|max:50',
            'email' => 'required|email',
            'first_name' => 'required|max:50',
            'last_name' => 'required|max:100',
            'password' => 'required|min:4'
        ]);
        $user = Auth::user();

        $user->username = $request['username'];
        $user->first_name = $request['first_name'];
        $user->last_name = $request['last_name'];
        $user->email = $request['email'];
        $user->password = bcrypt($request['password']);
        $user->save();

        return redirect()->route('account')->with(['message' => 'Your account has been successfully updated']);
    }

    public function postUpdateBio(Request $request)
    {
        $user = Auth::user();

        $user->about = $request['content'];
        if($user->save()){
            return redirect()->route('profile', Auth::user()->username)->with(['message' => 'Your bio/about section has been successfully updated']);
        }
    }

    // The start of nothing ness :)
    public function postUpdateBanner(Request $request)
    {
        $user = Auth::user();
        $file = $request->file('banner_image');
        $filename = $user->id . '-banner.jpg';
        $old_filename =$user->id . '-banner.jpg';
        $update = false;
        if (Storage::disk('local')->has($old_filename)) {
            $old_file = Storage::disk('local')->get($old_filename);
            Storage::disk('local')->put($filename, $old_file);
            $update = true;
        }
        if ($file) {
            Storage::disk('local')->put($filename, File::get($file));
        }
        if ($update && $old_filename !== $filename) {
            Storage::delete($old_filename);
        }
        return redirect()->route('account');
    }

    public function postUpdateProfile(Request $request)
    {
        $user = Auth::user();
        $file = $request->file('profile_image');
        $extention = File::extension($file);
        $filename = $user->id.'-profile.'.$extention;
        Image::make(Input::file('profile_image'))->resize(140, 140)->save($filename);
    }

    public function getUserImage($filename)
    {
        $file = Storage::disk('local')->get($filename);
        return new Response($file, 200);
    }
    // The end of nothing ness :)
}
