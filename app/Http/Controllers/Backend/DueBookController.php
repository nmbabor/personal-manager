<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Backend\CustomerController;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\CustomerDueBook;
use App\Models\CustomerLadger;


class DueBookController extends Controller
{
    public function oldDueBooks(Request $request, $id)
    {
        $customer = Customer::findOrFail($id);
        $dueBooks = $customer->dueBooks->where('close_date','!=',null);
        if(isset($request->order)){
            $dueBooks = $dueBooks->sortByDesc('id');
        }
        return view('backend.dueBook.index',compact('customer','dueBooks'));
    }
    public function oldDueBookDetails(Request $request, $id)
    {
        $dueBook = CustomerDueBook::findOrFail($id);
        $customer = $dueBook->customer;
        // calculate total due, deposit and current due
        $totalDue = $dueBook->ladgers->where('type', 'due')->sum('amount');
        $totalDeposit = $dueBook->ladgers->where('type', 'deposit')->sum('amount');
        $currentDue =  $totalDue - $totalDeposit;
        // get last ledger id
        $allData = $dueBook->ladgers;
        if(isset($request->order)){
            $allData = $allData->sortByDesc('id');
        }
        return view('backend.dueBook.details',compact('customer','allData','dueBook','currentDue','totalDue','totalDeposit'));
    }

    public function ladgerCreate(Request $request)
    {
       // if current due book not exist then create new due book
        $customerDueBook = CustomerDueBook::where('customer_id', $request->customer_id)
                ->where('close_date', null)->first();
        // get due book serial number based on user id
        $bookNo = CustomerDueBook::where('customer_id', $request->customer_id)->count() + 1;
        if (!$customerDueBook) {
            $customerDueBook = CustomerDueBook::create([
                'start_date' => now(),
                'customer_id' => $request->customer_id,
                'book_no' => $bookNo,
                'created_by' => auth()->id(),
                'updated_by' => auth()->id(),
            ]);
        }
        $request->merge(['customer_due_book_id' => $customerDueBook->id]);

        $request->validate([
            'amount' => 'required',
            'type' => 'required',
            'date' => 'required',
            'details' => 'required',
        ],
        [
            'amount.required' => 'টাকার পরিমাণ অবশ্যই দিতে হবে',
            'date.required' => 'তারিখ অবশ্যই দিতে হবে',
            'details.required' => 'বিবরণ অবশ্যই দিতে হবে',
        ]
    );

        try {
            $input = $request->except('_token');
            $input['date'] = date('Y-m-d', strtotime($request->date));
            $input['created_by'] = auth()->id();
            $input['updated_by'] = auth()->id();
            CustomerLadger::create($input);
            $type = $request->type == 'due' ? 'বকেয়া' : 'জমা';
            return back()->with('success', "$type এন্ট্রি সফল হয়েছে");
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
    public function ladgerUpdate(Request $request, $id)
    {
        $request->validate([
            'amount' => 'required',
            'date' => 'required',
            'details' => 'required',
        ],
        [
            'amount.required' => 'টাকার পরিমাণ অবশ্যই দিতে হবে',
            'date.required' => 'তারিখ অবশ্যই দিতে হবে',
            'details.required' => 'বিবরণ অবশ্যই দিতে হবে',
        ]
    );

        try {
            $input = $request->except('_token', '_method');
            $input['date'] = date('Y-m-d', strtotime($request->date));
            $input['updated_by'] = auth()->id();
            $ladger = CustomerLadger::findOrFail($id);
            $ladger->update($input);
            $type = $ladger->type == 'due' ? 'বকেয়া' : 'জমা';
            return back()->with('success', "$type এন্ট্রি আপডেট সফল হয়েছে");
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
    public function ladgerDelete($id)
    {
        try {
            $ladger = CustomerLadger::findOrFail($id);
            $ladger->delete();
            return back()->with('success', 'এন্ট্রি ডিলিট সফল হয়েছে');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function dueBookClose(Request $request){
        try {
        $customer = Customer::findOrFail($request->id);
        $dueBook = $customer->dueBooks->where('close_date',null)->first();
        // calculate total due, deposit and current due
        $totalDue = $dueBook->ladgers->where('type', 'due')->sum('amount');
        $totalDeposit = $dueBook->ladgers->where('type', 'deposit')->sum('amount');
        $currentDue =  $totalDue - $totalDeposit;
        // close current book and open new book
        $dueBook->update([
            'close_date'=>now()
        ]);
        $newBook = CustomerDueBook::create([
            'start_date' => now(),
            'book_no' => $dueBook->book_no + 1,
            'customer_id' => $request->id,
            'created_by' => auth()->id(),
            'updated_by' => auth()->id(),
        ]);
        // create new ladger
        $ladgerData = [
            'customer_id' => $request->id,
            'amount' => ($currentDue>0) ? $currentDue : $currentDue * (-1),
            'type' => ($currentDue > 0)?'due':'deposit',
            'date' => now(),
            'details' => "পূর্বের খাতার জের ". (($currentDue > 0)?'বাকি':'জমা'),
        ];
        $this->ladgerCreate(new Request($ladgerData));
        return back()->with('success', 'নতুন খাতা সফল ভাবে খোলা হয়েছে');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }


    }
}
