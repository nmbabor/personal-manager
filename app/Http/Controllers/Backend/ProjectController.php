<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\ProjectBasedDeposit;
use App\Models\ProjectBasedExpense;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Str;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $allData = Project::latest();

            return DataTables::of($allData)
                ->addIndexColumn()
                ->addColumn('DT_RowIndex','')
                ->addColumn('total_expense',function($data){
                    return $data->totalExpense();
                })
                ->addColumn('total_income',function($data){
                    return $data->totalIncome();
                })
                ->addColumn('created', function ($data) {
                    return date('d M, Y', strtotime($data->created_at));
                })
                ->addColumn('status', function ($data) {
                    if ($data->status == 1) {
                        return '<span class="badge badge-success" title="Completed"> <i class="fa fa-check"></i>
                        </span>';
                    }
                    elseif ($data->status == 0) {
                        return '<span class="badge badge-danger" title="Rejected"> <i class="fa fa-times"></i>
                        </span>';
                    } else {
                        return '<span class="badge badge-warning" title="Pending"> Pending </span>';
                    }
                })
                ->addColumn(
                    'action',
                    '<div class="action-wrapper">
                    <a class="btn btn-sm bg-success"
                        href="{{ route(\'projects.show\', $id) }}">
                        <i class="fas fa-eye"></i>
                    </a>
                </div>'
                )
                ->rawColumns(['created', 'action','total_expense','total_income','status'])
                ->toJson();
        }

        return view('backend.project.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $allData = Project::latest()->take(10)->get();
        return view('backend.project.create', compact('allData'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
        ]);
        try {
            $input = $request->except('_token');
            $input['slug'] = Str::slug($request->title);
            Project::create($input);
            return back()->with('success', 'Data created successfully');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $project = Project::findOrFail($id);
        $allData = ProjectBasedDeposit::where('project_id', $id)->get();
        $expenses = ProjectBasedExpense::where('project_id', $id)->get();
        $users = User::pluck('name', 'id');
        return view('backend.project.collection', compact('project', 'allData', 'users','expenses'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'title' => 'required',
        ]);

        try {
            $data = Project::findOrFail($id);
            $input = $request->except(['_token', '_method']);
            $input['slug'] = Str::slug($request->title);

            $data->update($input);
            return back()->with('success', 'Data updated successfully');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $data = Project::findOrFail($id);
            $data->delete();
            return back()->with('success', 'Data deleted successfully');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }


    public function paymentStore(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'project_id' => 'required',
            'paid_amount' => 'required',
            'payment_gateway' => 'required',
            'payment_date' => 'required',
        ]);

        try {
            $input = $request->except('_token');
            $input['payment_date'] = date('Y-m-d', strtotime($request->payment_date));
            $input['received_by'] = Auth::user()->id;

            ProjectBasedDeposit::create($input);
            return back()->with('success', 'Paymant submited successfully');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
    public function paymentUpdate(Request $request, $id)
    {
        $request->validate([
            'user_id' => 'required',
            'paid_amount' => 'required',
            'payment_gateway' => 'required',
            'payment_date' => 'required',
        ]);

        try {
            $data = ProjectBasedDeposit::findOrFail($id);
            $input = $request->except(['_token', '_method']);
            $input['payment_date'] = date('Y-m-d', strtotime($request->payment_date));
            //$input['received_by'] = \Auth::user()->id;
            $data->update($input);
            return back()->with('success', 'Paymant updated successfully');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function paymentDelete(string $id)
    {
        try {
            $data = ProjectBasedDeposit::findOrFail($id);
            $data->delete();
            return back()->with('success', 'Data deleted successfully');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function expenseStore(Request $request)
    {
        $request->validate([
            'project_id' => 'required',
            'total_amount' => 'required',
            'payment_date' => 'required',
        ]);

        try {
            $project =Project::findOrFail($request->project_id);
            $input = $request->except('_token');
            $input['payment_date'] = date('Y-m-d', strtotime($request->payment_date));
            $input['paid_by'] = Auth::user()->id;

            $oldExpenseCount = ProjectBasedExpense::where('project_id',$request->project_id)->count();
            if($oldExpenseCount == 0){
                $project->update([
                    'completed_date' => $input['payment_date'],
                    'status' => 1
                ]);
            }

            ProjectBasedExpense::create($input);
            return back()->with('success', 'Expense submited successfully');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
    public function expenseUpdate(Request $request, $id)
    {
        $request->validate([
            'total_amount' => 'required',
            'payment_date' => 'required',
        ]);

        try {
            $data = ProjectBasedExpense::findOrFail($id);
            $input = $request->except(['_token', '_method']);
            $input['payment_date'] = date('Y-m-d', strtotime($request->payment_date));
            $data->update($input);
            return back()->with('success', 'Expense updated successfully');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function expenseDelete(string $id)
    {
        try {
            $data = ProjectBasedExpense::findOrFail($id);
            $data->delete();
            return back()->with('success', 'Data deleted successfully');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
