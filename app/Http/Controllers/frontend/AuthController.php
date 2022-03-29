<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\LogTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    use LogTrait;

    public function showLogin()
    {
        return view('pages.auth.login');
    }

    public function login(Request $request)
    {
        $auth = [
            'email' => $request->email,
            'password' => $request->password,
            'active' => User::ACTIVE
        ];

        $remember = $request->remember == 'on';
        if (Auth::attempt($auth, $remember)) {
            $request->session()->regenerate();
            toastr()->success('Đăng nhập thành công.');
            // Redirect previous url
            if (session()->has('url.intended')) {
                return redirect()->intended(session()->get('url.intended'));
            } else {
                return redirect()->route('home');
            }
        } else {
            toastr()->error('Thông tin đăng nhập không chính xác hoặc tài khoản đã bị vô hiệu hóa.');
            return redirect()->route('login');
        }
    }

    /**
     * Logout
     * @param Request $request
     * @return void
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        toastr()->success('Đăng xuất thành công.');

        return redirect()->route('home');
    }
}
