@extends('backend.master')

@section('title', 'গ্রাহক এর পুরানো হিসাব সমূহ')
@section('title_button')
    <a href="{{ route('customers.index') }}" class="btn bg-gradient-primary" >
        <i class="fas fa-list"></i>
        সব গ্রাহক দেখুন
    </a>
@endsection
@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-bordered table-min-padding">
                        <tr>
                            <td width="25%"><b>গ্রাহকের নাম:</b> {{ $customer->name }} <i class="fa {!! $customer->status == 1 ? 'fa-check-circle text-success' : 'fa-times-circle text-danger' !!}"> </i> </td>
                            <td><b>মোবাইল নাম্বার:</b> {{ $customer->mobile_no ?? '' }} </td>
                            <td><b>ওয়ার্ড:</b> {{ $customer->word_no }} </td>
                        </tr>
                        <tr>
                            <td><b>ঠিকানা:</b> {{ $customer->address }} </td>
                            <td><b>পিতার নাম:</b> {{ $customer->father_name }} </td>
                            <td>
                            <a href="{{ route('customers.show', $customer->id) }}" class="btn btn-xs btn-success text-right"> <i class="fa fa-file"></i> &nbsp; নতুন খাতায় ফিরে যান </a>
                            </td>
                        </tr>
                    </table>
                </div>
                

                <div class="col-md-12 table-responsive">
                    @if(count($dueBooks)>0)
                    <h6> পুরানো বাকি এবং জমা খাতা : 
                    
                    </h6>
                    <table class="table table-bordered table-striped table-hover table-min-padding ">
                        <thead>
                            <tr class="text-center">
                                <th width="10%">খাতা নং</th>
                                <th width="13%">শুরুর তারিখ</th>
                                <th width="13%">বন্ধের তারিখ</th>
                                <th width="15%" >বাকি টাকা</th>
                                <th width="15%">জমা টাকা</th>
                                <th width="15%" class="bg-danger"> সর্বমোট বাকি / জমা </th>
                                <th width="10%" class="text-right">
                                    @if(request()->get('order') == 1)
                                        <a href="{{ request()->url() }}"> <i class="fa fa-arrow-up"></i> </a>
                                    @else
                                        <a href="{{ request()->fullUrlWithQuery(['order' => 1]) }}"> <i class="fa fa-arrow-down"></i> </a>
                                    @endif
                                 </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($dueBooks as $key => $data)
                                <tr>
                                    <td class="text-center">{{ en2bn($data->book_no) }}</td>
                                    <td>{{ en2bn(date('d-m-Y', strtotime($data->start_date))) }}</td>
                                    <td>{{ en2bn(date('d-m-Y', strtotime($data->close_date))) }}</td>
                                    <td class="text-right">{{ en2bn(number_format($data->ladgers->where('type', 'due')->sum('amount'), 0, '.', ',')) }}/-</td>
                                    <td class="text-right">{{ en2bn(number_format($data->ladgers->where('type', 'deposit')->sum('amount'), 0, '.', ',')) }}/-</td>
                                   
                                    <td class="text-right">
                                        @php
                                            $totalDue = $data->ladgers->where('type', 'due')->sum('amount');
                                            $totalDeposit = $data->ladgers->where('type', 'deposit')->sum('amount');
                                            $currentDue = $totalDue - $totalDeposit;
                                        @endphp
                                        @if($currentDue>0)
                                        <span style="font-size:100%" class="badge bg-danger fs-2"> {{ en2bn(number_format($currentDue, 0, '.', ',')) }}/- </span> <small>(বাকি)</small> 
                                        @else
                                        <span style="font-size:100%" class="badge bg-success"> {{ en2bn(number_format(($currentDue * (-1)), 0, '.', ',')) }}/- </span> <small>(জমা)</small>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('customers.old-due-book.show', $data->id) }}" class="btn btn-sm bg-gradient-info">বিস্তারিত</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        
                    </table>
                    @else
                    <p> এই গ্রাহকের কোন হিসাব এন্ট্রি নেই।</p>
                    @endif
                    
                </div>
                

            </div>
        </div>
    </div>
@endsection
