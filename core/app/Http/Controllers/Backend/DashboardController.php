<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\LinkSubmit;
use App\Models\Order;
use App\Models\Page;
use App\Models\Product;
use App\Models\SupportTicket;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUser = User::where('type','User')->count();

        
        return view('backend.dashboard.index',compact('totalUser'));
    }
    public function userDashboard()
    {
        $totalTransections = 0;
        
        return view('backend.dashboard.userDashboard',compact('totalTransections'));
    }

    public function profile()
    {
        $user = auth()->user();
        return view('backend.profile.index', compact('user'));
    }
}
