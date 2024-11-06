@extends('backend.master')

@section('title', 'Amount Disbursed / Loan')
@section('title_button')
    <a href="{{ route('amount-deposited.index') }}" class="btn bg-primary">
        <i class="fas fa-list"></i>
        View All
    </a>
@endsection
@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4 border-right">
                    <fieldset>
                        <form action="{{ route('amount-deposited.store') }}" method="post" id="addNewData">
                            @csrf
                            <div class="form-group">
                                <label class="col-md-12"> Amount <span class="text-danger">*</span> : </label>
                                <div class="col-md-12">
                                    <input type="number" min="0" class="form-control" placeholder="Ex: 500"
                                        name="amount" required>
                                </div>
                            </div>
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
                                <label class="col-md-12"> Type <span class="text-danger">*</span> : </label>
                                <div class="col-md-12">
                                    {!! Form::select('type', $types, 'collector', ['class' => 'form-control', 'required']) !!}
                                    @error('type')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-12"> Status <span class="text-danger">*</span> : </label>
                                <div class="col-md-12">
                                    {!! Form::select('is_withdrawn', ['Disbursed','Repaid'], 0 , ['class' => 'form-control', 'required']) !!}
                                    @error('is_withdrawn')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-12"> Transaction Date : </label>
                                <div class="col-md-12">
                                    <input type="text" class="form-control singleDatePicker" placeholder="Date"
                                        name="transaction_date" value="{{ date('d-m-Y') }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-12"> Reference : </label>
                                <div class="col-md-12">
                                    <input type="text" class="form-control" placeholder="Reference" name="reference">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-12">Description : </label>
                                <div class="col-md-12">
                                    <textarea class="form-control" placeholder="Description" name="details"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-12">
                                    <button type="submit" class="btn bg-gradient-primary">
                                        Submit
                                    </button>
                                </div>
                            </div>

                        </form>
                    </fieldset>
                    <hr>
                </div>

                <div class="col-md-8 table-responsive">
                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Member</th>
                                <th>Amount</th>
                                <th>Date</th>
                                <th width="5%">Status</th>
                                <th class="text-center" width="20%">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($allData as $data)
                                <tr>
                                    <td>{{ $data->user->name ?? '' }}</td>
                                    <td>{{ $data->amount }}</td>
                                    <td>{{ date('d-m-Y',strtotime($data->transaction_date)) }}</td>
                                    <td>
                                        @if ($data->is_withdrawn == 1)
                                          <b class="text-success">Repaid</b>  
                                        @elseif($data->status == 0)
                                            <b class="text-danger">Disbursed</b>  
                                        @endif
                                    </td>
                                    <td>

                                        <div class="text-center">
                                            <button title="View Data" type="button" class="btn btn-primary btn-xs"
                                                data-toggle="modal" data-target="#viewData-{{ $data->id }}">
                                                <i class="fas fa-eye"></i>
                                            </button>

                                            <!-- Button trigger modal -->
                                            <button title="Edit Data" type="button" class="btn btn-info btn-xs"
                                                data-toggle="modal" data-target="#editData-{{ $data->id }}">
                                                <i class="fas fa-pencil-alt"></i>
                                            </button>
                                            @if ($data->isEditable())
                                                <a class="btn btn-danger btn-xs" data-bs-toggle="tooltip"
                                                    data-bs-placement="top" data-bs-title="Delete Data"
                                                    href="javascript:void(0)"
                                                    onclick='resourceDelete("{{ route('amount-deposited.destroy', $data->id) }}")'>
                                                    <span class="delete-icon">
                                                        <i class="fas fa-trash-alt"></i>
                                                </a>
                                            @endif
                                        </div>
                                        <!--View Modal -->
                                        <div class="modal fade" id="viewData-{{ $data->id }}" tabindex="-1"
                                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title fs-5" id="exampleModalLabel">
                                                            <i class="fas fa-eye"></i>
                                                            View Data
                                                        </h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <table class="table">
                                                            <tr>
                                                                <th>Member:</th>
                                                                <td>{{ $data->user->name ?? '' }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Amount:</th>
                                                                <td>{{ $data->amount }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Date:</th>
                                                                <td>{{ date('d-m-Y',strtotime($data->transaction_date)) }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Type:</th>
                                                                <td>{{ $data->type }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Status:</th>
                                                                <td>
                                                                    @if ($data->is_withdrawn == 1)
                                                                      <b class="text-success">Repaid</b>  
                                                                    @elseif($data->status == 0)
                                                                        <b class="text-danger">Disbursed</b>  
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>Reference:</th>
                                                                <td>{{ $data->reference }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Details:</th>
                                                                <td>{{ $data->details }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Create Date:</th>
                                                                <td>{{ date('d-m-Y',strtotime($data->created_at)) }}</td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Edit Modal -->
                                        <div class="modal fade" id="editData-{{ $data->id }}" tabindex="-1"
                                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                {!! Form::open(['method' => 'put', 'route' => ['amount-deposited.update', $data->id]]) !!}
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title fs-5" id="exampleModalLabel">
                                                            <i class="fas fa-pencil-alt"></i>
                                                            Edit Data
                                                        </h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label class="col-md-12"> Amount <span class="text-danger">*</span> : </label>
                                                            <div class="col-md-12">
                                                                <input type="number" min="0" class="form-control" placeholder="Ex: 500"
                                                                    name="amount" value="{{$data->amount}}" required>
                                                            </div>
                                                        </div>
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
                                                            <label class="col-md-12"> Type <span class="text-danger">*</span> : </label>
                                                            <div class="col-md-12">
                                                                {!! Form::select('type', $types, $data->type, ['class' => 'form-control', 'required']) !!}
                                                                @error('type')
                                                                    <span class="text-danger">{{ $message }}</span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-md-12"> Status <span class="text-danger">*</span> : </label>
                                                            <div class="col-md-12">
                                                                {!! Form::select('is_withdrawn', ['Disbursed','Repaid'], $data->is_withdrawn , ['class' => 'form-control', 'required']) !!}
                                                                @error('is_withdrawn')
                                                                    <span class="text-danger">{{ $message }}</span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-md-12"> Transaction Date : </label>
                                                            <div class="col-md-12">
                                                                <input type="text" class="form-control singleDatePicker" placeholder="Date"
                                                                    name="transaction_date" value="{{ date('d-m-Y',strtotime($data->transaction_date)) }}">
                                                            </div>
                                                        </div>
                            
                                                        <div class="form-group">
                                                            <label class="col-md-12"> Reference : </label>
                                                            <div class="col-md-12">
                                                                <input type="text" class="form-control" placeholder="Reference" name="reference" value="{{$data->reference}}">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-md-12">Description : </label>
                                                            <div class="col-md-12">
                                                                <textarea class="form-control" placeholder="Description" name="details">{{$data->details}}</textarea>
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
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
