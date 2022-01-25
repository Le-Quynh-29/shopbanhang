<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.auth.login');
    }

    public function dashboard()
    {
        return view('admin.home');
    }
}
