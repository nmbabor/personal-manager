<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\AmountDeposited;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class AmountDepositedController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $allUserAmounts = AmountDeposited::calculateAllUserAmounts();
        return view('backend.amountDeposited.index', compact('allUserAmounts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $allData = AmountDeposited::latest()->take(10)->get();
        $users = User::pluck('name', 'id');
        $types = [
            'collector'=>'collector',
            'loan'=>'loan',
            'unofficial'=>'unofficial'
        ];
        return view('backend.amountDeposited.create', compact('allData','users','types'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'amount' => 'required',
            'type' => 'required',
            'transaction_date' => 'required',
        ]);

        try {
            $input = $request->except('_token');
            $input['transaction_date'] = date('Y-m-d', strtotime($request->transaction_date));

            AmountDeposited::create($input);
            return back()->with('success', 'Amount submited successfully');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($userId)
    {
        $user = User::findOrFail($userId);
        $totalDue = count($user->dueMonths()) * $user->monthly_amount;
        $allData = AmountDeposited::where('user_id',$userId)->orderBy('id','ASC')->get();
        return view('backend.amountDeposited.userDetails', compact('allData','user','totalDue'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AmountDeposited $amountDeposited)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AmountDeposited $amountDeposited)
    {
        $request->validate([
            'user_id' => 'required',
            'amount' => 'required',
            'type' => 'required',
            'transaction_date' => 'required',
        ]);

        try {
            $input = $request->except('_token');
            $input['transaction_date'] = date('Y-m-d', strtotime($request->transaction_date));

            $amountDeposited->update($input);
            return back()->with('success', 'Amount updated successfully');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AmountDeposited $amountDeposited)
    {
        try {
            $amountDeposited->delete();
            return back()->with('success', 'Data deleted successfully');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
