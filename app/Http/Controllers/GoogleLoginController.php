<?php

namespace App\Http\Controllers;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\UserModel;
use App\Models\ProfileModel as Profile;

class GoogleLoginController extends Controller
{

    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback(Request $request)
    {
        $googleUser = Socialite::driver('google')->stateless()->user();

        $email = $googleUser->getEmail();
        $googleName = $googleUser->getName();
        $fallbackName = Str::random(7);

        $profile = Profile::where('email', $email)->first();

        if (!$profile) {

            $fullname = $googleName ?: $fallbackName;
            $username = explode('@', $email)[0];

            $user = UserModel::create([
                'username' => $username,
                'password' => Hash::make(\Config::get('services.google.password')),
                'fullname' => $fullname,
            ]);

            $profile = Profile::create([
                'user_id' => $user->id,
                'email' => $email,
                'name' => $fullname,
                'address' => '',
                'birthday' => '',
                'phone' => '',
                'image' => $googleUser->getAvatar() ?? '',
            ]);

        } else {

            $user = UserModel::find($profile->user_id);

            if (empty($user->fullname)) {
                $user->fullname = $googleName ?: $fallbackName;
                $user->save();
            }

            if (empty($profile->name)) {
                $profile->name = $googleName ?: $fallbackName;
                $profile->save();
            }
        }


        $request->session()->put('user_id', $user->id);
        $request->session()->put('username', $user->username);
        $request->session()->put('fullname', $user->fullname);
        $request->session()->put(
            'is_admin',
            str_contains($user->username, 'admin')
        );

        return redirect('/');
    }
}