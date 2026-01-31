<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    public function showForgotForm()
    {
        return view('auth.forgot-password');
    }

    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:profile,email',
        ], [
            'email.exists' => 'Email không tồn tại trong hệ thống',
        ]);

        $token = Str::random(64);

        DB::table('password_resets')->updateOrInsert(
            ['email' => $request->email],
            [
                'token' => $token,
                'created_at' => now()
            ]
        );

        $resetLink = route('password.reset', $token);

        Mail::send('mail.reset-password', compact('resetLink'), function ($message) use ($request) {
            $message->to($request->email)
                ->subject('Khôi phục mật khẩu');
        });


        return back()->with('success', 'Link đổi mật khẩu đã được gửi về email');
    }

    public function showResetForm($token)
    {
        return view('auth.reset-password', compact('token'));
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:profile,email',
            'password' => 'required|min:6|confirmed',
            'token' => 'required'
        ]);

        $check = DB::table('password_resets')
            ->where('email', $request->email)
            ->where('token', $request->token)
            ->first();

        if (!$check) {
            return back()->withErrors(['email' => 'Link không hợp lệ hoặc đã hết hạn']);
        }

        $profile = DB::table('profile')
            ->where('email', $request->email)
            ->first();

        if ($profile) {
            DB::table('users')
                ->where('id', $profile->user_id)
                ->update([
                    'password' => Hash::make($request->password)
                ]);
            Mail::send(
                'mail.password-changed',
                [
                    'newPassword' => $request->password
                ],
                function ($message) use ($request) {
                    $message->to($request->email)
                        ->subject('Mật khẩu của bạn đã được thay đổi');
                }
            );
        }
        DB::table('password_resets')->where('email', $request->email)->delete();

        return redirect('/login')->with('success', 'Đổi mật khẩu thành công');
    }
}
