<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Http\Requests\Auth\SendMailRequest;
use App\Repository\UserRepository;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function showFormLogin()
    {
        return view('auth.login');
    }

    public function login(LoginRequest $request)
    {
        $request->authenticate();

        $request->session()->regenerate();

        if (Auth::user()->is_admin) {
            return redirect()->route('admin');
        }

        return redirect()->intended('/');
    }

    public function logout(Request $request)
    {
        \Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function showFormRegister()
    {
        return view('auth.register');
    }

    public function register(RegisterRequest $request)
    {
        $data = [
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => Hash::make($request->password),
            'email_verified_at' => null,
        ];
        $user = resolve(UserRepository::class)->create($data);
        event(new Registered($user));
        Auth::login($user);

        return redirect()->route('verification.notice')->with('msg', 'Đã gửi mail xác nhận, vui lòng kiểm tra email của bạn');
    }

    public function showFormVerify()
    {
        if (Auth::user()->email_verified_at) {
            return redirect()->route('home');
        }
        return view('auth.verify-email');
    }

    public function sendMailVerify(SendMailRequest $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended('/');
        }

        $request->user()->sendEmailVerificationNotification();

        return back()->with('msg', 'Đã gửi mail xác nhận, vui lòng kiểm tra email của bạn');
    }

    public function verify(EmailVerificationRequest $request)
    {
        $request->fulfill();

        return redirect()->intended('/');
    }

    public function showFormForgotPassword()
    {
        return view('auth.forgot-password');
    }

    public function sendMailResetPassword(SendMailRequest $request)
    {
        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with(['status' => 'Đã gửi mail'])
            : back()->withErrors(['email' => 'Email không tồn tại']);
    }

    public function showFormResetPassword($token)
    {
        $email = \request()->email;
        return view('auth.reset-password', ['token' => $token, 'email' => $email]);
    }

    public function resetPassword(ResetPasswordRequest $request)
    {
        $status = Password::reset(
            $request->only('email', 'password', 'passwordConfirm', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('auth.login')->with('status', __($status))
            : back()->withErrors(['email' => [__($status)]]);
    }
}
