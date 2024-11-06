@extends('backend.master')

@section('title', 'Amount Disbursed / Loan')
@section('title_button')
    <a href="{{ route('amount-deposited.create') }}" class="btn bg-primary" >
        <i class="fas fa-plus-circle"></i>
        Add New
    </a>
@endsection
@section('content')
    <div class="card">
        <div class="card-body p-2 p-md-4 pt-0">
            <div class="row g-4">
                <div class="col-md-12">
                    <div class="card-body table-responsive p-0" id="table_data">
                        <table id="datatables" class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Member</th>
                                    <th>Total Disbursed</th>
                                    <th>Total Repaid</th>
                                    <th>Payable Amount</th>
                                    <th class="text-center" width="8%">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $totlaPayable = 0;   
                                @endphp
                                @foreach ($allUserAmounts as $data)
                                    @php
                                     $totlaPayable += $data->final_amount;   
                                    @endphp
                                    <tr>
                                        <td>{{ $data->user->name ?? 'N/A' }}</td>
                                        <td>{{ $data->total_deposit }}</td>
                                        <td>{{ $data->total_withdrawn }}</td>
                                        <td>{{ $data->final_amount }}</td>
                                        <td>
                                            <a href="{{route('amount-deposited.show', $data->user_id)}}" class="btn btn-success btn-xs"><i class="fa fa-eye"></i> Details</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr class="bg-light">
                                    <th colspan="3" class="text-right"> Total Payable: </th>
                                    <th>{{$totlaPayable}}</th>
                                    <td></td>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    
@endpush
