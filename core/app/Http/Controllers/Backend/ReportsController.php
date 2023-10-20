<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\MonthlyDeposit;
use App\Models\Project;
use App\Models\User;
use App\Models\YearlyClosingAmount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class ReportsController extends Controller
{
    public function due()
    {
        $users = User::where(['type' => 'User', 'is_suspended' => 0])->get();
        return view('backend.reports.due', compact('users'));
    }

    public function projects(Request $request)
    {
        $projects = Project::where(['status' => 1]);
        if (isset($request->year)) {
            $projects = $projects->whereYear('completed_date', $request->year);
        }
        $projects = $projects->get();
        $currentYear = date('Y');
        $yearsArray = [];

        for ($year = 2021; $year <= $currentYear; $year++) {
            $yearsArray[$year] = $year;
        }
        return view('backend.reports.projects', compact('projects', 'yearsArray', 'request'));
    }
    public function monthlyCollection(Request $request)
    {

        $currentYear = date('Y');
        $selectYear = $request->year ?? date('Y');
        $users = User::where(['type' => 'User'])->get();
        $collection = $request->collection ?? false;
        $grandTotal = 0;
        $monthTotal = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
        foreach ($users as $user) {
            $userTotal = 0;
            $user->total_amount = 0;
            $user->amount = [];
            $userAmount = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
            if (isset($request->month)) {
                foreach ($request->month as $monthNo) {
                    $amount = $user->payment($selectYear, $monthNo, $collection);
                    $grandTotal += $amount;
                    $monthTotal[$monthNo] += $amount;
                    $user->total_amount += $amount;
                    $userAmount[$monthNo] = $amount;
                    $user->amount = $userAmount;
                }
            } else {
                foreach (months() as $monthNo => $month) {
                    $amount = $user->payment($selectYear, $monthNo, $collection);
                    $grandTotal += $amount;
                    $monthTotal[$monthNo] += $amount;
                    $user->total_amount += $amount;
                    $userAmount[$monthNo] = $amount;
                    $user->amount = $userAmount;
                }
            }
        }
        $yearsArray = [];

        for ($year = 2021; $year <= ($currentYear+1); $year++) {
            $yearsArray[$year] = $year;
        }
        return view('backend.reports.monthlyCollection', compact('yearsArray', 'request', 'users', 'selectYear', 'collection', 'grandTotal', 'monthTotal'));
    }

    public function incomeExpense(Request $request)
    {
        $selectedYear = $request->year ?? date('Y');
        $monthlyCollection = MonthlyDeposit::whereYear('payment_date',$selectedYear)->sum('paid_amount');
        $projects = Project::where(['status' => 1])->whereYear('completed_date', $selectedYear)->get();
        $closing = YearlyClosingAmount::where('closing_year',$selectedYear -1)->first();

        return view('backend.reports.incomeExpense', compact('projects', 'selectedYear','monthlyCollection','closing'));
    }

    public function closeYear(Request $request){
        $validator = Validator::make($request->all(), [
            'closing_date'=>'required',
            'amount'=>'required',
            'year'=>'required',
        ]);
        if ($validator->fails()) {
            $errors = $validator->errors();
            if ($errors->any()) {
                $firstError = $errors->first();
                return back()->with('error', $firstError);
            }
        }

        try {
            $data = YearlyClosingAmount::where('closing_year',$request->year)->first();
            if($data!= null){
                $data->update([
                    'closing_amount' => $request->amount,
                    'closing_date' => date('Y-m-d',strtotime($request->closing_date)),
                    'closed_by' => Auth::user()->id
                ]);
            }else{
                YearlyClosingAmount::create([
                    'closing_amount' => $request->amount,
                    'closing_date' => date('Y-m-d',strtotime($request->closing_date)),
                    'closed_by' => Auth::user()->id,
                    'closing_year' => $request->year,
                ]);
            }
            return back()->with('success', 'Closed year successfully');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }



}
