<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLogRequest;
use App\Http\Requests\UpdateLogRequest;
use App\Models\Log;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogController extends Controller
{
    public function index()
    {
        return view('admin.auth.login');
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
            if (Auth::user()->role === User::ADMIN) {
                return redirect()->route('dashboard');
            } else {
                return redirect()->route('home');
            }
        } else {
            toastr()->error('Thông tin đăng nhập không chính xác hoặc tài khoản đã bị vô hiệu hóa.');
            return redirect()->route('admin.login.show');
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

        return redirect()->route('admin.login.show');
    }
}
