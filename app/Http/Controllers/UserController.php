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
        /*$this->validate($request, [
            'username' => 'required|max:50|unique:users',
            'email' => 'required|email|unique:users',
            'first_name' => 'required|max:50',
            'last_name' => 'required|max:100',
            'password' => 'required|min:4'
        ]);*/
        //return response("Test 1");
        $user = Auth::user();
        $old_username = $user->username;

        $user->username = $request['username'];
        $user->first_name = $request['first_name'];
        $user->last_name = $request['last_name'];
        $user->email = $request['email'];
        $user->password = bcrypt($request['password']);
        $user->update();

        /*$profile_file = $request->file('profile_image');
        $banner_file = $request->file('banner_image');

        $profile_extension = $request->file('profile_image')->extension();
        $banner_extension = $request->file('banner_image')->extension();

        $filename_profile = $request['username'] . '-' . $user->id . '-profile.'.$profile_extension;
        $filename_banner = $request['username'] . '-' . $user->id . '-banner.'.$banner_extension;

        $old_filename_profile = $old_username . '-' . $user->id . '-profile.'.$profile_extension;
        $old_filename_banner = $old_username . '-' . $user->id . '-banner.'.$banner_extension;

        $profile_update = false;
        $banner_update = false;

        // Profile image
        if (Storage::disk('local')->has($filename_profile)) {
            $old_file = Storage::disk('local')->get($old_filename_profile);
            Storage::disk('local')->put($filename_profile, $old_file);
            $profile_update = true;
        }
        if ($profile_file) {
            Storage::disk('local')->put($filename_profile, File::get($profile_file));
        }
        if ($profile_update && $old_filename_profile !== $filename_profile) {
            Storage::delete($old_filename_profile);
        }

        // Banner Image
        if (Storage::disk('local')->has($filename_banner)) {
            $old_file = Storage::disk('local')->get($old_filename_banner);
            Storage::disk('local')->put($filename_banner, $old_file);
            $banner_update = true;
        }
        if ($banner_file) {
            Storage::disk('local')->put($filename_banner, File::get($banner_file));
        }
        if ($banner_update && $old_filename_banner !== $filename_banner) {
            Storage::delete($old_filename_banner);
        }*/

        return redirect()->route('account');
    }
    public function getUserImage($filename)
    {
        $file = Storage::disk('local')->get($filename);
        return new Response($file, 200);
    }
}