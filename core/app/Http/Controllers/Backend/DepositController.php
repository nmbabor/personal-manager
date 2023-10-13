<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\MonthlyDeposit;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DepositController extends Controller
{


    public function show($id)
    {
        $user = User::findOrFail($id);
        $dueMonthCount = count($user->dueMonths());
        $totalDue = $dueMonthCount * $user->monthly_amount;
        $allData = MonthlyDeposit::where('user_id', $id)->get();
        return view('backend.deposit.userDetails', compact('user', 'allData', 'dueMonthCount', 'totalDue'));
    }

    
    public function monthlyDeposit(Request $request)
    {
        $request->validate([
            'total_months' => 'required',
            'payment_gateway' => 'required',
            'total_paid' => 'required',
            'payment_date' => 'required',
        ]);

        try {
            $user = User::findOrFail($request->user_id);
             $lastPay = MonthlyDeposit::where('user_id',$request->user_id)->orderBy('payment_year','DESC')->orderBy('payment_month','DESC')->first();
            // Get the due months
             $dueMonths = $user->dueMonths();

            $total_months = $request->total_months;
            $paymentAmountPerMonth = $user->monthly_amount;
            $payments = [];

            foreach ($dueMonths as $dueMonth) {
                $currentMonth = new \DateTime($dueMonth);
                if ($total_months == 0) {
                    break;
                }
                $paymentRow = [
                    'user_id' => $request->user_id,
                    'payment_month' => $currentMonth->format('m'),
                    'payment_year' => $currentMonth->format('Y'),
                    'payable_amount' => $paymentAmountPerMonth,
                    'paid_amount' => $paymentAmountPerMonth,
                    'is_paid' => 1,
                    'payment_gateway' => $request->payment_gateway,
                    'reference_no' => $request->reference_no,
                    'note' => $request->note,
                    'payment_date' => date('Y-m-d', strtotime($request->payment_date)),
                    'received_by' => Auth::user()->id,
                    'created_at' => now()
                ];
                if (isset($request->special_consider)) {
                    $paymentRow['paid_amount'] = 0;
                    $paymentRow['payment_gateway'] = '';
                    $paymentRow['reference_no'] = 'consider';
                }
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
                    'user_id' => $request->user_id,
                    'payment_month' => $currentMonth->format('m'),
                    'payment_year' => $currentMonth->format('Y'),
                    'payable_amount' => $paymentAmountPerMonth,
                    'paid_amount' => $paymentAmountPerMonth,
                    'is_paid' => 1,
                    'payment_gateway' => $request->payment_gateway,
                    'reference_no' => $request->reference_no,
                    'note' => $request->note,
                    'payment_date' => date('Y-m-d', strtotime($request->payment_date)),
                    'received_by' => Auth::user()->id,
                    'created_at' => now()
                ];
                if (isset($request->special_consider)) {
                    $paymentRow['paid_amount'] = 0;
                    $paymentRow['payment_gateway'] = '';
                    $paymentRow['reference_no'] = 'consider';
                }
                $payments[] = $paymentRow;
                $total_months--;
            }

            MonthlyDeposit::insert($payments);

            return back()->with('success', 'Paid successfully');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function monthlyDepositUpdate(Request $request,$id){
        $request->validate([
            'payment_gateway' => 'required',
            'payment_date' => 'required',
        ]);
        $payment = MonthlyDeposit::findOrFail($id);
        $payment->update([
            'payment_gateway' => $request->payment_gateway,
            'payment_date' => date('Y-m-d',strtotime($request->payment_date)),
            'reference_no' => $request->reference_no,
            'note' => $request->note,
        ]);
        try {
            return back()->with('success', 'Payment updated successfully');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
    public function destroy($id)
    {

        $user = MonthlyDeposit::findOrFail($id);
        $user->delete();

        return back()->with('success', 'Payment deleted');
    }
}
