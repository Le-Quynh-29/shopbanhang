<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;

Paginator::useBootstrap();
class DashboardController extends Controller
{
    public function dashboard()
    {
//        $this->authorize("viewAny", User::class);
        return view('admin.home');
    }
}
