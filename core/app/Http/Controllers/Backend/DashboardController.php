<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\LinkSubmit;
use App\Models\MonthlyDeposit;
use App\Models\Order;
use App\Models\Page;
use App\Models\Product;
use App\Models\Project;
use App\Models\ProjectBasedExpense;
use App\Models\SupportTicket;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $users = User::where(['type' => 'User', 'is_suspended' => 0])->get();
        $projects = Project::where(['status' => 1])->count();
        $expense = ProjectBasedExpense::sum('total_amount');
        $collection = MonthlyDeposit::whereMonth('payment_date',date('m'))->whereYear('payment_date',date('Y'))->sum('paid_amount');
        
        return view('backend.dashboard.index',compact('users','projects','expense','collection'));
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
