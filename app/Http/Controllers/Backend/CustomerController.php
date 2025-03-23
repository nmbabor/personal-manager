<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\CustomerLadger;
use App\Models\CustomerDueBook;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $allData = Customer::latest();
    
            return DataTables::of($allData)
                ->addIndexColumn()
                ->addColumn('DT_RowIndex','')
                ->editColumn('name_link','<a href="{{ route(\'customers.show\', $id) }}">{{ $name }} </a>')
                ->addColumn('total_due', function ($data) {
                    $dueBook = CustomerDueBook::where('customer_id', $data->id)->where('close_date',null)->first();
                    if($dueBook){
                        $totalDue = $dueBook->ladgers->where('type', 'due')->sum('amount');
                        $totalDeposit = $dueBook->ladgers->where('type', 'deposit')->sum('amount');
                        return $totalDue - $totalDeposit;
                    }
                    return 0;
                    
                })
                ->addColumn(
                    'action',
                    '<div class="action-wrapper">
                        <a class="btn btn-xs bg-success"
                            href="{{ route(\'customers.show\', $id) }}">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a class="btn btn-xs bg-gradient-warning"
                            href="{{ route(\'customers.edit\', $id) }}">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a class="btn btn-danger btn-xs" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="ডিলেট করুন"
                                        href="javascript:void(0)"
                                        onclick=\'resourceDelete("{{ route(\'customers.destroy\', $id) }}")\'>
                                        <span class="delete-icon">
                        <i class="fas fa-trash-alt"></i>
                    </a>
                </div>'
                )
                ->rawColumns(['name_link','total_due', 'action'])
                ->toJson();
        }
        
        return view('backend.customer.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $words = [1=>1,2=>2,3=>3,4=>4,5=>5,6=>6,7=>7,8=>8,9=>9];
        return view('backend.customer.create',compact('words'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'mobile_no' => 'required|unique:customers,mobile_no',
        ], [
            'name.required' => 'নাম অবশ্যই দিতে হবে',
            'mobile_no.required' => 'মোবাইল নম্বর অবশ্যই দিতে হবে',
            'mobile_no.unique' => 'এই মোবাইল নম্বর ইতিমধ্যে নেওয়া হয়েছে',
        ]);
        
        try{
            $input = $request->except('_token');
            $input['created_by'] = auth()->id();
            $customer = Customer::create($input)->id;
            if($request->amount > 0){
                $ladgerData = [
                    'customer_id' => $customer,
                    'amount' => $request->amount,
                    'type' => 'due',
                    'date' => now(),
                    'details' => $request->details,
                ];
                $this->ladgerCreate(new Request($ladgerData));
            }
        
        return to_route('customers.index')->with('success', 'গ্রাহক তৈরি সফল হয়েছে');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer, Request $request)
    {
        $totalDue = 0;
        $totalDeposit = 0;
        $currentDue = 0;
        $lastId = null;
        $allData = [];
        $dueBook = $customer->dueBooks->where('close_date',null)->first();
        if($dueBook){
            // calculate total due, deposit and current due
            $totalDue = $dueBook->ladgers->where('type', 'due')->sum('amount');
            $totalDeposit = $dueBook->ladgers->where('type', 'deposit')->sum('amount');
            $currentDue =  $totalDue - $totalDeposit;
            // get last ledger id
            $lastId = $dueBook->ladgers->sortByDesc('id')->first()->id;
            $allData = $dueBook->ladgers;
            if(isset($request->order)){
                $allData = $allData->sortByDesc('id');
            }
        }
        return view('backend.customer.show',compact('customer','allData','lastId','currentDue','totalDue','totalDeposit','dueBook'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        $words = [1=>1,2=>2,3=>3,4=>4,5=>5,6=>6,7=>7,8=>8,9=>9];
        return view('backend.customer.edit',compact('customer','words'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Customer $customer)
    {
        $request->validate([
            'name' => 'required',
            'mobile_no' => "required|unique:customers,mobile_no,$customer->id",
        ]);

        try {
            $input = $request->except(['_token', '_method']);
            $input['status'] = $request->status ? 1 : 0;

            $customer->update($input);
            return back()->with('success', 'গ্রাহক তথ্য আপডেট সফল হয়েছে');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        try {
            $customer->delete();
            return back()->with('success', 'গ্রাহক ডিলিট সফল হয়েছে');
        } catch (\Exception $e) {
            if ($e->getCode() == 1451) {
                return back()->with('error', 'এই গ্রাহককে ডিলিট করা সম্ভব নয় কারণ তার হিসাব এন্ট্রি রয়েছে');
            }
            return back()->with('error', 'এই গ্রাহককে ডিলিট করা সম্ভব নয় কারণ তার হিসাব এন্ট্রি রয়েছে');
        }
    }

    public function ladgerCreate(Request $request)
    {
       // if current due book not exist then create new due book
        $customerDueBook = CustomerDueBook::where('customer_id', $request->customer_id)
                ->where('close_date', null)->first();
        if (!$customerDueBook) {
            $customerDueBook = CustomerDueBook::create([
                'start_date' => now(),
                'customer_id' => $request->customer_id,
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
