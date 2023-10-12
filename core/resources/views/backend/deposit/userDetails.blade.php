@extends('backend.master')

@section('title', 'Deposit')
@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-bordered table-min-padding">
                        <tr>
                            <td width="25%"><b>Name:</b> {{ $user->name }} </td>
                            <td><b>Mobile No:</b> {{ $user->mobile_no ?? '' }} </td>
                            <td><b>Country:</b> {{ $user->country->name ?? '' }} </td>
                        </tr>
                        <tr>
                            <td><b>Monthly Amount:</b> {{ $user->monthly_amount }} TK </td>
                            <td><b>Word No:</b> {{ $user->word_no }} </td>
                            <td><b>Start Date:</b> {{ date('d-m-Y', strtotime($user->deposit_start_date)) }} </td>
                        </tr>
                        @if ($dueMonthCount > 0)
                            <tr>
                                <td> <b>Due Amounts: </b> <b class="text-danger">{{ $totalDue }} TK </b> </td>
                                <td colspan="2">
                                    <b class="text-danger">Due Months({{ $dueMonthCount }}):</b>
                                    @foreach ($user->dueMonths() as $due)
                                        <span class="badge badge-danger"> {{ date('M, Y', strtotime($due)) }} </span>
                                    @endforeach
                                </td>
                            </tr>
                        @endif
                    </table>
                </div>
                <div class="col-md-5 border-right">
                    <fieldset>
                        <form action="{{ route('deposit.monthly') }}" method="post" id="addNewData">
                            @csrf
                            <input type="hidden" name="user_id" value="{{$user->id}}">
                            <div class="form-group">
                                <label class="col-md-12"> Total Month & PGW <span class="text-danger">*</span> : </label>
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-5 mb-1">
                                            <input type="number" id="totalMonths" class="form-control" placeholder="Ex: 1"
                                                name="total_months" min="0" value="1">
                                            <input type="hidden" id="monthly_amount" name="monthly_amount"
                                                value="{{ $user->monthly_amount }}">
                                            @error('total_months')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-md-7">
                                            {!! Form::select('payment_gateway', paymentGateway(), 'bkash', ['class' => 'form-control', 'required']) !!}
                                            @error('payment_gateway')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-12"> Payable Amount : </label>
                                <div class="col-md-12">
                                    <input type="number" id="payableAmounts" readonly class="form-control" value="500"
                                        min="500" name="total_paid">
                                </div>
                                <div class="col-md-12">
                                    <label><input type="checkbox" id="special_consider" name="special_consider"> Special
                                        Consideration </label>
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

                <div class="col-md-7 table-responsive">
                    <table class="table table-bordered table-striped table-hover table-min-padding">
                        <thead>
                            <tr>
                                <th>Payment Date</th>
                                <th>Month</th>
                                <th>Amount</th>
                                <th class="text-center" width="20%">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($allData as $key => $data)
                                <tr>
                                    <td>{{ date('d-m-Y', strtotime($data->payment_date)) }}</td>
                                    <td>{{ date('M, Y', strtotime($data->payment_month_year)) }}</td>
                                    <td>{{ $data->paid_amount }} Tk</td>
                                    <td>
                                        @if((count($allData)-1) == $key)
                                        <div class="text-center">
                                            <!-- Button trigger modal -->
                                            <button title="Edit Category" type="button" class="btn btn-info btn-xs"
                                                data-toggle="modal" data-target="#editCategory-{{ $data->id }}">
                                                <i class="fas fa-pencil-alt"></i>
                                            </button>
                                            <a class="btn btn-danger btn-xs" data-bs-toggle="tooltip"
                                                data-bs-placement="top" data-bs-title="Delete Data"
                                                href="javascript:void(0)"
                                                onclick='resourceDelete("{{ route('deposit.monthly.delete', $data->id) }}")'>
                                                <span class="delete-icon">
                                                    <i class="fas fa-trash-alt"></i>
                                            </a>
                                        </div>

                                        <!-- Modal -->
                                        <div class="modal fade" id="editCategory-{{ $data->id }}" tabindex="-1"
                                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                {!! Form::open(['method' => 'put', 'route' => ['text-slider.update', $data->id]]) !!}
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
                                                        <table class="table table-min-padding">
                                                            <tr>
                                                                <th> Month :</th>
                                                                <td> {{ date('M, Y', strtotime($data->payment_month_year)) }} </td>
                                                            </tr>
                                                            <tr>
                                                                <th> Amount :</th>
                                                                <td> {{ $data->paid_amount }} Tk </td>
                                                            </tr>
                                                        </table>
                                                        <div class="form-group">
                                                            
                                                            <label class="col-md-12"> Payment Gateway : </label>
                                                            <div class="col-md-12">
                                                                {!! Form::select('payment_gateway', paymentGateway(), 'bkash', ['class' => 'form-control', 'required']) !!}
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
                                                                <label><input type="checkbox" class="mt-2" name="special_consider"> Special
                                                                    Consideration </label>
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
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script>
        $(document).ready(function() {
            $("#totalMonths").on('keyup click blur', function() {
                let isChecked = $("#special_consider").prop("checked");
                if(!isChecked){
                    totalAmountCalculation()
                }
            });

            function totalAmountCalculation(){
                let totalMonths = parseInt($('#totalMonths').val());
                let amount = parseInt($('#monthly_amount').val());
                let total = totalMonths * amount;
                $("#payableAmounts").val(total);
            }

            $('#special_consider').change(function() {
                if (this.checked) {
                    $('#payableAmounts').val('0');
                } else {
                    totalAmountCalculation()
                }
            });
        });
    </script>
@endpush
