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
use Illuminate\Support\Facades\File;

class DashboardController extends Controller
{
    public function index()
    {
       /*  $json = File::get('assets/users.json');

        $data = json_decode($json, true);
        foreach ($data as $item) {
            $item['password'] = bcrypt($item['mobile_no']);
            User::create($item);
        }

        return $data; */
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
    public function autoFill()
    {
        $users = User::where(['type' => 'User', 'is_suspended' => 0])->whereNotIn('id',[46])->get();
        //return $users;
        $payment_gateway = 'bKash';
        foreach($users as $user){
            $total_months = 2;
            $lastPay = MonthlyDeposit::where('user_id',$user->id)->orderBy('payment_year','DESC')->orderBy('payment_month','DESC')->first();
            // Get the due months
             $dueMonths = $user->dueMonths();


            $paymentAmountPerMonth = $user->monthly_amount;
            $payments = [];

            foreach ($dueMonths as $dueMonth) {
                $currentMonth = new \DateTime($dueMonth);
                if ($total_months == 0) {
                    break;
                }
                $paymentRow = [
                    'user_id' => $user->id,
                    'payment_month' => $currentMonth->format('m'),
                    'payment_year' => $currentMonth->format('Y'),
                    'payable_amount' => $paymentAmountPerMonth,
                    'paid_amount' => $paymentAmountPerMonth,
                    'is_paid' => 1,
                    'payment_gateway' => $payment_gateway,
                    'reference_no' => '',
                    'note' => 'Previous',
                    'payment_date' => "2023-02-01",
                    'received_by' => Auth::user()->id,
                    'created_at' => now()
                ];
                $payments[] = $paymentRow;
                $total_months--;
            }
            // Add payments for future months (in advance)
            if(isset($dueMonth)){
                if(isset($lastPay->payment_month_year)){
                    $lastPaymentMonth = new \DateTime($lastPay->payment_month_year);
                    if($lastPaymentMonth->format('Y-m')>$dueMonth){
                        $currentMonth = new \DateTime($lastPay->payment_month_year);
                    }else{
                        $currentMonth = new \DateTime($dueMonth);
                    }
                }else{
                    $currentMonth = new \DateTime($dueMonth);
                }
            }elseif(isset($lastPay->payment_month_year)){
                $currentMonth = new \DateTime($lastPay->payment_month_year);
            }else{
                $currentMonth = now();
            }
            while ($total_months > 0) {
                $currentMonth->modify('+1 month');
                $paymentRow = [
                    'user_id' => $user->id,
                    'payment_month' => $currentMonth->format('m'),
                    'payment_year' => $currentMonth->format('Y'),
                    'payable_amount' => $paymentAmountPerMonth,
                    'paid_amount' => $paymentAmountPerMonth,
                    'is_paid' => 1,
                    'payment_gateway' => $payment_gateway,
                    'reference_no' => '',
                    'note' => 'Previous',
                    'payment_date' => "2022-04-01",
                    'received_by' => Auth::user()->id,
                    'created_at' => now()
                ];
                $payments[] = $paymentRow;
                $total_months--;
            }

            MonthlyDeposit::insert($payments);
        }
        return "yes";

    }
}
