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
        return redirect()->back();
    }
    public function postLogout()
    {
        Auth::logout();

        return redirect()->route('home');
    }

    public function getAccount()
    {
        return view('account', ['user' => Auth::user()]);
    }

    public function postSaveAccount(Request $request)
    {
        $this->validate($request, [
            'username' => 'required|max:50|unique:users',
            'email' => 'required|email|unique:users',
            'first_name' => 'required|max:50',
            'last_name' => 'required|max:100',
            'password' => 'required|min:4'
        ]);
        $user = Auth::user();
        $old_username = $user->username;

        $user->username = $request['username'];
        $user->email = $request['email'];
        $user->first_name = $request['first_name'];
        $user->last_name = $request['last_name'];
        $user->password = bcrypt($request['password']);
        $user->update();

        $file = $request->file('image');
        $extension = $request->file('image')->extension();
        $filename_profile = $request['username'] . '-' . $user->id . '-profile.'.$extension;
        $filename_banner = $request['username'] . '-' . $user->id . '-banner.'.$extension;
        $old_filename_profile = $old_username . '-' . $user->id . '-profile.'.$extension;
        $old_filename_banner = $old_username . '-' . $user->id . '-banner.'.$extension;
        $update = false;

        // Profile image
        if (Storage::disk('local')->has($filename_profile)) {
            $old_file = Storage::disk('local')->get($old_filename_profile);
            Storage::disk('local')->put($filename_profile, $old_file);
            $update = true;
        }
        if ($file) {
            Storage::disk('local')->put($filename_profile, File::get($file));
        }
        if ($update && $old_filename_profile !== $filename_profile) {
            Storage::delete($old_filename_profile);
        }

        // Banner Image
        if (Storage::disk('local')->has($filename_banner)) {
            $old_file = Storage::disk('local')->get($old_filename_banner);
            Storage::disk('local')->put($filename_banner, $old_file);
            $update = true;
        }
        if ($file) {
            Storage::disk('local')->put($filename_banner, File::get($file));
        }
        if ($update && $old_filename_banner !== $filename_banner) {
            Storage::delete($old_filename_banner);
        }

        return redirect()->route('account');
    }
    public function getUserImage($filename)
    {
        $file = Storage::disk('local')->get($filename);
        return new Response($file, 200);
    }
}