@extends('backend.master')

@section('title', 'Project Collection & Expense')
@section('title_button')
    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#newPayment">
        <i class="fa fa-plus-circle"></i> New Collection
    </button>
    <a href="{{ route('projects.index') }}" class="btn bg-primary" >
        <i class="fas fa-list"></i>
         All Projects
    </a>
@endsection
@section('content')
    <!-- Modal -->

    <div class="card">
        <!-- Button trigger modal -->
        <div class="modal fade" id="newPayment">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{ route('projects.collection') }}" method="post" id="addNewData">
                        @csrf
                        <input type="hidden" name="project_id" value="{{$project->id}}">
                        <div class="modal-header">
                            <h4 class="modal-title">Add new payment</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label class="col-md-12"> Member <span class="text-danger">*</span> : </label>
                                <div class="col-md-12">
                                    {!! Form::select('user_id',$users,'',['class'=>'form-control select2','required','placeholder'=>'- Select Member -']) !!}
                                    @error('user_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-12"> Amount : </label>
                                <div class="col-md-12">
                                    <input type="number" min="0" class="form-control" placeholder="Ex: 500"
                                        name="paid_amount" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-12"> Payment Gateway <span class="text-danger">*</span> : </label>
                                <div class="col-md-12">
                                    {!! Form::select('payment_gateway', paymentGateway(), 'bkash', ['class' => 'form-control', 'required']) !!}
                                    @error('payment_gateway')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-12"> Reference Note : </label>
                                <div class="col-md-12">
                                    <input type="text" class="form-control" placeholder="TrxID/Last 3 Digit"
                                        name="reference_no">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-12"> Payment Date : </label>
                                <div class="col-md-12">
                                    <input type="text" class="form-control singleDatePicker" placeholder="Date"
                                        name="payment_date" value="{{ date('d-m-Y') }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-12">Description : </label>
                                <div class="col-md-12">
                                    <textarea class="form-control" placeholder="Description" name="note"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-md-5 border-right">
                    <h5> Project Details </h5>
                    <table class="table table-bordered table-min-padding">
                        <tr>
                            <th class="text-right" width="30%"> Project Title: </th>
                            <td>{{ $project->title }} </td>
                        </tr>
                        <tr>
                            <th class="text-right"> Address: </th>
                            <td>{{ $project->address }} </td>
                        </tr>
                        <tr>
                            <th class="text-right">Reference:</th>
                            <td>{{ $project->reference }} </td>
                        </tr>
                        <tr>
                            <th class="text-right"> Details: </th>
                            <td>{{ $project->details }} </td>
                        </tr>
                    </table>
                    {{-- Project Expense Start --}}
                    <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#projectExpense">
                        <i class="fa fa-plus-circle"></i> Project Expense
                    </button>
                    <div class="modal fade" id="projectExpense">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="{{ route('projects.expense') }}" method="post" id="addNewData">
                                    @csrf
                                    <input type="hidden" name="project_id" value="{{$project->id}}">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Add Project Expense</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        
                                        <div class="form-group">
                                            <label class="col-md-12"> Amount : </label>
                                            <div class="col-md-12">
                                                <input type="number" min="0" class="form-control" placeholder="Ex: 500"
                                                    name="total_amount" required>
                                            </div>
                                        </div>
                                      
                                        <div class="form-group">
                                            <label class="col-md-12"> Payment Date : </label>
                                            <div class="col-md-12">
                                                <input type="text" class="form-control singleDatePicker" placeholder="Date"
                                                    name="payment_date" value="{{ date('d-m-Y') }}">
                                            </div>
                                        </div>
            
                                        <div class="form-group">
                                            <label class="col-md-12">Description : </label>
                                            <div class="col-md-12">
                                                <textarea class="form-control" placeholder="Description" name="note"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer justify-content-between">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    {{-- Project Expense Add Modal End --}}
                    @if(count($expenses)>0)
                    <table class="table table-bordered table-striped table-hover mt-2">
                        <thead>
                            <tr>
                                <th width="3%">#</th>
                                <th>Expense Date</th>
                                <th>Note</th>
                                <th>Amount</th>
                                <th class="text-center" width="20%">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $totalExpense = 0; @endphp
                            @foreach ($expenses as $xKey => $expense)
                            @php $totalExpense += $expense->total_amount; @endphp
                                <tr>
                                    <td> {{$xKey+1}} </td>
                                    <td>{{ date('d-m-Y',strtotime($expense->payment_date)) }}</td>
                                    <td>{{ $expense->note }}</td>
                                    <td>{{ $expense->total_amount }}</td>
                                    <td>
                                        @if($expense->isEditable())
                                        <div class="text-center">
                                            <!-- Button trigger modal -->
                                            <button title="Edit Expense" type="button" class="btn btn-info btn-xs"
                                                data-toggle="modal" data-target="#editExpenseData-{{ $expense->id }}">
                                                <i class="fas fa-pencil-alt"></i>
                                            </button>
                                            <a class="btn btn-danger btn-xs" data-bs-toggle="tooltip"
                                                data-bs-placement="top" data-bs-title="Delete Data"
                                                href="javascript:void(0)"
                                                onclick='resourceDelete("{{ route('projects.expense.delete', $expense->id) }}")'>
                                                <span class="delete-icon">
                                                    <i class="fas fa-trash-alt"></i>
                                            </a>
                                        </div>

                                        <!-- Modal -->
                                        <div class="modal fade" id="editExpenseData-{{ $expense->id }}" tabindex="-1"
                                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                {!! Form::open(['method' => 'put', 'route' => ['projects.expense.update', $expense->id]]) !!}
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title fs-5" id="exampleModalLabel">
                                                            <i class="fas fa-pencil-alt"></i>
                                                            Edit Expense
                                                        </h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        
                                                        <div class="form-group">
                                                            <label class="col-md-12"> Amount : </label>
                                                            <div class="col-md-12">
                                                                <input type="number" min="0" class="form-control" placeholder="Ex: 500"
                                                                    name="total_amount" value="{{$expense->total_amount}}" required>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-md-12"> Payment Date : </label>
                                                            <div class="col-md-12">
                                                                <input type="text" class="form-control singleDatePicker" placeholder="Date"
                                                                    name="payment_date" value="{{ date('d-m-Y',strtotime($expense->payment_date)) }}">
                                                            </div>
                                                        </div>
                            
                                                        <div class="form-group">
                                                            <label class="col-md-12">Description : </label>
                                                            <div class="col-md-12">
                                                                <textarea class="form-control" placeholder="Description" name="note">{{$expense->note}}</textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn bg-gradient-secondary"
                                                            data-dismiss="modal">
                                                            Close
                                                        </button>
                                                        <button type="submit" class="btn bg-gradient-primary">
                                                            Save changes
                                                        </button>
                                                    </div>
                                                </div>
                                                {!! Form::close() !!}
                                            </div>
                                        </div>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        @if(count($expenses)>1)
                        <tfoot>
                            <tr style="background: #ddd">
                                <th class="text-right" colspan="3"> Total Expense: </th>
                                <th>{{$totalExpense}} TK</th>
                                <th></th>
                            </tr>
                        </tfoot>
                        @endif
                    </table>
                    @endif
                    {{-- Project Expense End --}}
                </div>

                <div class="col-md-7 table-responsive">
                    <h5> Collections </h5>
                    <table class="table table-bordered table-striped table-hover table-min-padding">
                        <thead>
                            <tr>
                                <th width="3%">#</th>
                                <th>Payment Date</th>
                                <th>Member</th>
                                <th>Amount</th>
                                <th class="text-center" width="20%">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $totalCollection = 0; @endphp
                            @foreach ($allData as $key => $data)
                            @php $totalCollection += $data->paid_amount; @endphp
                                <tr>
                                    <td> {{$key+1}} </td>
                                    <td>{{ date('d-m-Y',strtotime($data->payment_date)) }}</td>
                                    <td>{{ $data->user->name ??'' }}</td>
                                    <td>{{ $data->paid_amount }}</td>
                                    <td>
                                        @if($data->isEditable())
                                        <div class="text-center">
                                            <!-- Button trigger modal -->
                                            <button title="Edit Payment" type="button" class="btn btn-info btn-xs"
                                                data-toggle="modal" data-target="#editData-{{ $data->id }}">
                                                <i class="fas fa-pencil-alt"></i>
                                            </button>
                                            <a class="btn btn-danger btn-xs" data-bs-toggle="tooltip"
                                                data-bs-placement="top" data-bs-title="Delete Data"
                                                href="javascript:void(0)"
                                                onclick='resourceDelete("{{ route('projects.collection.delete', $data->id) }}")'>
                                                <span class="delete-icon">
                                                    <i class="fas fa-trash-alt"></i>
                                            </a>
                                        </div>

                                        <!-- Modal -->
                                        <div class="modal fade" id="editData-{{ $data->id }}" tabindex="-1"
                                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                {!! Form::open(['method' => 'put', 'route' => ['projects.collection.update', $data->id]]) !!}
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title fs-5" id="exampleModalLabel">
                                                            <i class="fas fa-pencil-alt"></i>
                                                            Edit Payment
                                                        </h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label class="col-md-12"> Member <span class="text-danger">*</span> : </label>
                                                            <div class="col-md-12">
                                                                {!! Form::select('user_id',$users,$data->user_id,['class'=>'form-control select2','required','placeholder'=>'- Select Member -']) !!}
                                                                @error('user_id')
                                                                    <span class="text-danger">{{ $message }}</span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-md-12"> Amount : </label>
                                                            <div class="col-md-12">
                                                                <input type="number" min="0" class="form-control" placeholder="Ex: 500"
                                                                    name="paid_amount" value="{{$data->paid_amount}}" required>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-md-12"> Payment Gateway <span class="text-danger">*</span> : </label>
                                                            <div class="col-md-12">
                                                                {!! Form::select('payment_gateway', paymentGateway(), $data->payment_gateway, ['class' => 'form-control', 'required']) !!}
                                                                @error('payment_gateway')
                                                                    <span class="text-danger">{{ $message }}</span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-md-12"> Reference Note : </label>
                                                            <div class="col-md-12">
                                                                <input type="text" class="form-control" placeholder="TrxID/Last 3 Digit"
                                                                    name="reference_no" value="{{$data->reference_no}}">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-md-12"> Payment Date : </label>
                                                            <div class="col-md-12">
                                                                <input type="text" class="form-control singleDatePicker" placeholder="Date"
                                                                    name="payment_date" value="{{ date('d-m-Y',strtotime($data->payment_date)) }}">
                                                            </div>
                                                        </div>
                            
                                                        <div class="form-group">
                                                            <label class="col-md-12">Description : </label>
                                                            <div class="col-md-12">
                                                                <textarea class="form-control" placeholder="Description" name="note">{{$data->note}}</textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn bg-gradient-secondary"
                                                            data-dismiss="modal">
                                                            Close
                                                        </button>
                                                        <button type="submit" class="btn bg-gradient-primary">
                                                            Save changes
                                                        </button>
                                                    </div>
                                                </div>
                                                {!! Form::close() !!}
                                            </div>
                                        </div>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        @if(count($allData)>1)
                        <tfoot>
                            <tr style="background: #ddd">
                                <th class="text-right" colspan="3"> Total Collection: </th>
                                <th>{{$totalCollection}} TK</th>
                                <th></th>
                            </tr>
                        </tfoot>
                        @endif
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
