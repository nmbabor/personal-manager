<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\CustomerDueBook;
use App\Models\CustomerLadger;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalCustomers = Customer::where('status',1)->count();
        // all due books where close date is null, theirs all ledgers sum of due amount and sum of deposit amount and then calculate the current due amount
        $dueBooks = CustomerDueBook::where('close_date',null)->get();
        $totalDue = 0;
        foreach($dueBooks as $dueBook){
            $due = $dueBook->ladgers->where('type','due')->sum('amount') - $dueBook->ladgers->where('type','deposit')->sum('amount');
            if($due>0){
                $totalDue += $due;
            }
        }
        // today's due list
        $dueList = CustomerLadger::with('customer')->where('date', date('Y-m-d'))
            ->where('type', 'due')
            ->whereHas('customerDueBook', function($query) {
            $query->where('close_date', null);
            })
            ->get();
        // today's deposti list
        $depositList = CustomerLadger::with('customer')->where('date', date('Y-m-d'))
            ->where('type', 'deposit')
            ->whereHas('customerDueBook', function($query) {
            $query->where('close_date', null);
            })
            ->get();
        
        return view('backend.dashboard.index',compact('totalCustomers','totalDue','dueList','depositList'));
    }

    public function profile()
    {
        $user = auth()->user();
        return view('backend.profile.index', compact('user'));
    }
    
}
