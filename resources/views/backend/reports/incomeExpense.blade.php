@extends('backend.master')

@section('title', 'Income Expense')
@section('title_button')
    <button class="btn btn-sm btn-info" id="printBtn"><i class="fa fa-print"></i> Print</button>
@endsection
@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row mb-2">
                <div class="col-md-2">
                    <form action="{{ route('reports.income-expense') }}">

                        <div class="input-group mb-3">
                            {{ Form::select('year', years(), $selectedYear, ['class' => 'form-control']) }}
                            <button class="btn btn-secondary" type="submit" id="button-addon2">Find</button>
                        </div>

                    </form>
                </div>
            </div>

                <div class="print-body" id="printBody">
                    <style>
                        .print-body {
                            width: 900px;
                            background: #fff;
                            margin: 5px auto;
                        }

                        .print-body .row {
                            margin: 0;
                        }
                        .print-body .col-md-6 {
                           width: 50%;
                        }
                        .print-header{
                            background: #d2f7fe;
                            padding: 5px;
                            border-bottom: 2px solid #a9dcbc;
                            position: relative;
                        }
                        .print-logo{
                            position: absolute;
                            left: 30px;
                        }

                        .print-only {
                            display: none
                        }
                        .watermark {
                            width: 100%;
                            height: 100%;
                            text-align: center;
                            position: absolute;
                            top: 0;
                            left: 0;
                            display: flex;
                            align-items: center;
                            justify-content: center;
                            z-index: 11;
                        }
                        .watermark img {
                            width: 400px;
                            opacity: .07;
                            margin: 0 auto;
                        }

                        @page {
                            margin: 0 0 0 0;
                            size: A4 portrait;
                        }

                        @media print {
                            html, body {
                                width: 100%;
                                height: 100vh;
                            }

                            .print-body {
                                width: 98%;
                            }
                            .print-body table {
                                background: transparent;
                            }

                            .print-none {
                                display: none;
                            }

                            .print-only {
                                display: inline
                            }
                            .table td, .table th{color:#000}
                            .watermark {
                                height: 100vh;
                            }
                            .watermark img {
                                width: 600px;
                                margin: 0 auto;
                            }
                        }
                    </style>
                    <table style="width: 100%">
                        <thead>
                            <tr>
                                <th>
                                    <div class="row print-header">
                                        <div class="print-logo"  style="text-align:center">
                                            <img style="width: 75px" src="{{ imageRecover(readconfig('site_logo')) }}" />
                                        </div>
                                        <div class=" col-md-12 print-header-text" style="text-align:center">
                                            <p style="margin: 0"> বিসমিল্লাহির রাহমানির রাহীম </p>
                                            <h5 style="color: green;margin: 0"> ৭ নং ধর্মপুর ইউনিয়ন প্রবাসী কল্যাণ ট্রাষ্ট </h5>
                                            <h6> অসহায় ও সুবিধা বঞ্চিত মানুষের সেবাই আমাদের মূল লক্ষ্য </h6>
                                        </div>
                                    </div>
                                    <h6 style="text-align: center; margin-top: 5px;"> বাৎসরিক আয় ব্যয় হিসাব, {{$selectedYear}} </h6>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                <div class="row" style="position: relative">
                                    <div class="watermark">
                                        <img src="{{ imageRecover(readconfig('site_logo')) }}">
                                    </div>
                                    <div class="col-md-6" style="float: left">
                                        <table class="table table-bordered">
                                            <thead>
                                            <tr>
                                                <th colspan="3" style="text-align: center"> আয়</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td width="5%">1</td>
                                                <td>  {{$selectedYear-1}} সালের অবশিষ্ট এমাউন্ট</td>
                                                <td style="text-align: right">{{$closing->closing_amount ?? ''}}</td>
                                            </tr>
                                            <tr>
                                                <td>2</td>
                                                <td>মাসিক চাঁদা</td>
                                                <td style="text-align: right">{{ $monthlyCollection }}</td>
                                            </tr>
                                            @php
                                                $i = 3;
                                                $totalIncome = $closing->closing_amount ?? 0; // Add Previous Amount;
                                                $totalIncome += $monthlyCollection;
                                            @endphp
                                            @foreach ($projects as $project)
                                                @php
                                                    $income = $project->totalIncome();
                                                    $totalIncome += $income;
                                                @endphp
                                                @if ($income > 0)
                                                    <tr>
                                                        <td>{{ $i++ }}</td>
                                                        <td>{{ $project->title }}</td>
                                                        <td style="text-align: right">{{ $income }}</td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                            </tbody>
                                            <tfoot>
                                            <tr class="bg-primary">
                                                <th colspan="2" style="text-align:right"> মোট আয়:</th>
                                                <th style="text-align:right"> {{ $totalIncome }} </th>
                                            </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                    <div class="col-md-6" style="float: right">
                                        <table class="table table-bordered">
                                            <thead>
                                            <tr>
                                                <th colspan="3" style="text-align: center"> ব্যয়</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @php
                                                $i = 1;
                                                $totalExpense = 0;
                                            @endphp
                                            @foreach ($projects as $project)
                                                @php
                                                    $expense = $project->totalExpense();
                                                    $totalExpense += $expense;
                                                @endphp
                                                @if ($expense > 0)
                                                    <tr>
                                                        <td>{{ $i++ }}</td>
                                                        <td>{{ $project->title }}</td>
                                                        <td style="text-align: right">{{ $expense }}</td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                            </tbody>
                                            <tfoot>
                                            <tr class="bg-primary">
                                                <th colspan="2" style="text-align:right"> মোট ব্যয়:</th>
                                                <th style="text-align:right"> {{ $totalExpense }} </th>
                                            </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label class="bg-success form-control text-center"> অবশিষ্ট এমাউন্ট : <b
                                                    style="font-size: 20px">{{ $totalIncome - $totalExpense }} </b> </label>
                                            @if(Auth::user()->type == 'Admin')
                                                <button type="button" class="btn btn-danger print-none" data-toggle="modal" data-target="#myModal">
                                                    Close Year
                                                </button>
                                                <!-- Button trigger modal -->


                                                <!-- Modal -->
                                                <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h4 class="modal-title" id="myModalLabel"> Close Year </h4>
                                                                <button type="button" class="close" data-dismiss="modal"
                                                                        aria-label="Close"><span
                                                                        aria-hidden="true">&times;</span></button>
                                                            </div>
                                                            {!! Form::open(['route'=>'reports.close-year','method'=>'post']) !!}
                                                            <input type="hidden" name="amount" value="{{$totalIncome - $totalExpense}}">
                                                            <input type="hidden" name="year" value="{{$selectedYear}}">
                                                            <div class="modal-body">
                                                                <h6> Closing Year: <b>{{$selectedYear}}</b></h6>
                                                                <h6> Closing Amount: <b> {{ $totalIncome - $totalExpense }} </b></h6>
                                                                <input type="text" class="form-control singleDatePicker" name="closing_date"
                                                                       placeholder="Closing Date" value="{{date('d-m-Y')}}">
                                                            </div>
                                                            <div class="modal-footer">

                                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close
                                                                </button>
                                                                <button type="submit" class="btn btn-primary">Submit</button>
                                                            </div>
                                                            {!! Form::close() !!}
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
            </div>

        </div>
    </div>
@endsection
@push('script')
    <script src="{{asset('assets/backend/js/jQuery.print.js')}}"></script>
    <script>
        $(function(){
            $('#printBtn').on('click', function() {
                $("#printBody").print();
            });
        });
    </script>
@endpush
