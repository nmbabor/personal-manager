@extends('backend.master')

@section('title', 'গ্রাহক এর পুরানো খাতা নং - '.en2bn($dueBook->book_no))
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
                    @php 
                        $dueTitle = ($currentDue>0)?'বাকি':'জমা';
                    @endphp
                    <table class="table table-bordered table-min-padding">
                        <tr>
                            <td><b>গ্রাহকের নাম:</b> {{ $customer->name }} <i class="fa {!! $customer->status == 1 ? 'fa-check-circle text-success' : 'fa-times-circle text-danger' !!}"> </i> </td>
                            <td  width="25%"><b>মোবাইল নাম্বার:</b> {{ $customer->mobile_no ?? '' }} </td>
                            <td  width="25%"><b>ওয়ার্ড:</b> {{ $customer->word_no }} </td>
                        </tr>
                        <tr>
                            <td><b>ঠিকানা:</b> {{ $customer->address }} </td>
                            <td><b>পিতার নাম:</b> {{ $customer->father_name }} </td>
                            <td>
                            <a href="{{ route('customers.show', $customer->id) }}" class="btn btn-xs btn-success text-right"> <i class="fa fa-file"></i> &nbsp; নতুন খাতায় ফিরে যান </a>
                            <a href="{{ route('customers.old-due-books', $customer->id) }}" class="btn btn-xs btn-danger text-right"> <i class="fa fa-file"></i> &nbsp; পুরানো খাতা সমূহ দেখুন </a>
                            </td>
                        </tr>
                    </table>
                </div>
                

                <div class="col-md-12 table-responsive">
                    @if(count($allData)>0)
                    <h6> বাকি এবং জমা হিসাব @if(isset($dueBook->start_date))<small> (খাতা নং - {{en2bn($dueBook->book_no)}}, শুরুঃ {{en2bn(date('d-m-Y',strtotime($dueBook->start_date)))}}, শেষঃ {{en2bn(date('d-m-Y',strtotime($dueBook->close_date)))}}) </small> @endif : 
                    
                    </h6>
                    <table class="table table-bordered table-hover table-min-padding ">
                        <thead>
                            <tr class="text-center">
                                <th width="13%">তারিখ</th>
                                <th>বিবরণ</th>
                                <th width="15%">বাকি টাকা</th>
                                <th width="15%">জমা টাকা</th>
                                <th width="5%" class="text-right">
                                    @if(request()->get('order') == 1)
                                        <a href="{{ request()->url() }}"> <i class="fa fa-arrow-up"></i> </a>
                                    @else
                                        <a href="{{ request()->fullUrlWithQuery(['order' => 1]) }}"> <i class="fa fa-arrow-down"></i> </a>
                                    @endif
                                 </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($allData as $key => $data)
                                <tr class="{{($data->type != 'due') ? 'bg-light-success' : ''}}">
                                    <td>{{ en2bn(date('d-m-Y', strtotime($data->date))) }}</td>
                                    <td>{{ $data->details }}</td>
                                    <td class="text-right">
                                        @if ($data->type == 'due')
                                            {{ en2bn(number_format($data->amount, 0, '.', ',')) }}/-
                                        @endif
                                    </td>
                                    <td class="text-right">
                                        @if ($data->type != 'due')
                                           <span class="px-2"> {{ en2bn(number_format($data->amount, 0, '.', ',')) }}/- </span>
                                        @endif
                                    </td>
                                    <td>
                                        
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        @if(count($allData)>1)
                        <tfoot>
                            <tr class="bg-secondary">
                                <th colspan="2" class="text-right"> <b>মোট টাকা:</b> </th>
                                <th class="text-right"> <b>{{ en2bn(number_format($totalDue, 0, '.', ',')) }}/-
                                    </b> </th>
                                <th class="text-right"> <b>{{ en2bn(number_format($totalDeposit, 0, '.', ',')) }}/-
                                    </b> </th>
                                <th></th>
                            </tr>
                            <tr class="bg-info">
                                <th colspan="2" class="text-right"> <b>এই খাতার চূড়ান্ত {{$dueTitle}}:</b> </th>
                                <th colspan="2" class="text-right"> 
                                    @if($currentDue>0)
                                    <b>{{ en2bn(number_format($currentDue, 0, '.', ',')) }}/-</b>
                                    @else
                                    <b>{{ en2bn(number_format(($currentDue * (-1)), 0, '.', ',')) }}/-</b>
                                    @endif
                                 </th>
                                
                                <th></th>
                            </tr>
                        </tfoot>
                        @endif
                    </table>
                    @else
                    <p> এই খাতায় কোন হিসাব এন্ট্রি নেই।</p>
                    @endif
                    
                </div>
                

            </div>
        </div>
    </div>
@endsection
