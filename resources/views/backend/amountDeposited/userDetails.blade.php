@extends('backend.master')

@section('title', 'User Wise Amount Disbursed / Loan')
@section('title_button')
<a href="{{ route('amount-deposited.index') }}" class="btn bg-primary">
    <i class="fas fa-list"></i>
    View All
</a>
@endsection
@section('content')
    <div class="card">
        <div class="card-body p-2 p-md-4 pt-0">
            <div class="row g-4">
                <div class="col-md-12">
                    <table class="table table-bordered table-min-padding">
                        <tr>
                            <td width="25%"><b>Name:</b> {{ $user->name }} </td>
                            <td><b>Mobile No:</b> {{ $user->mobile_no ?? '' }} </td>
                            <td><b>Country:</b> {{ $user->country->name ?? '' }} </td>
                        </tr>
                        <tr>
                            <td><b>Monthly Amount:</b> {{ $user->monthly_amount }} TK @if ($totalDue > 0) (Due: <b class="text-danger">{{ $totalDue }} TK </b>) @endif </td>
                            <td><b>Word No:</b> {{ $user->word_no }} </td>
                            <td><b>Start Date:</b> {{ date('d-m-Y', strtotime($user->deposit_start_date)) }} </td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-12">
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Type</th>
                                    <th>Reference</th>
                                    <th>Details</th>
                                    <th width="5%">Status</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                 $totalDisbursed = 0;   
                                 $totalPaid = 0;   
                                 $totalPayable = 0;   
                                @endphp
                                @foreach ($allData as $data)
                                @php
                                    $totalDisbursed = 0;   
                                    $totalPaid = 0;   
                                    $totalPayable += $data->is_withdrawn? - $data->amount : $data->amount ;   
                                @endphp
                                    <tr>
                                        <td>{{ date('d-m-Y',strtotime($data->transaction_date)) }}</td>
                                        <td>{{ $data->type }}</td>
                                        <td>{{ $data->reference }}</td>
                                        <td>{{ $data->details }}</td>
                                        <td>
                                            @if ($data->is_withdrawn == 1)
                                            <b class="text-success">Repaid</b>  
                                            @elseif($data->status == 0)
                                                <b class="text-danger">Disbursed</b>  
                                            @endif
                                        </td>
                                        <td>{{ $data->amount }}</td>
                                    </tr>
                                @endforeach
                                <tr class="bg-light">
                                    <th colspan="5" class="text-right"> Total Payable </th>
                                    <th> {{$totalPayable}} </th>

                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    
@endpush
