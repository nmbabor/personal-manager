@extends('backend.master')

@section('title', 'Monthly Collection')
@section('title_button')
    <button class="btn btn-sm btn-info" id="printBtn"><i class="fa fa-print"></i> Print</button>
@endsection
@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row mb-2">
                <div class="col-md-3">
                    <form action="{{ route('reports.monthly-collection') }}">
                        <div>
                            <label> <input type="checkbox" value="1" name="collection"
                                           @if ($collection) checked @endif> Only Collection </label>
                        </div>
                        <div class="mb-2">
                            {{ Form::select('month[]', months(1), $request->month ?? '', ['class' => 'form-control select2', 'multiple', 'data-placeholder' => 'All Months']) }}
                        </div>
                        <div class="input-group mb-3">
                            {{ Form::select('year', $yearsArray, $selectYear, ['class' => 'form-control']) }}
                            <button class="btn btn-secondary" type="submit" id="button-addon2">Find</button>
                        </div>

                    </form>
                </div>
            </div>
            <div class="row">
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
                            margin: 10px 10px 10px 10px;
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
                            <td>
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
                                <h6 style="text-align: center; margin-top: 5px; margin-bottom: 0"> মাসিক @if(isset($request->collection)) কালেকশান @else জমা @endif</h6>
                                <p  style="text-align: center; margin-bottom: 0px;">@if (isset($request->month)) @foreach($request->month as $mKey => $month) @if($mKey>0) , @endif {{date('M',strtotime('2023/'.$month.'/01'))}} @endforeach, @endif  {{$selectYear}}  </p>
                            </td>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>
                    <div class="col-md-12 table-responsive">
                        <table class="table table-bordered table-striped table-hover table-min-padding">
                            <thead>
                            <tr class="bg-info">
                                <th width="2%">#</th>
                                <th>Member Name</th>
                                <th>Mobile No</th>
                                @if (isset($request->month))
                                    @foreach ($request->month as $month)
                                        <th>{{ months()[$month] }}</th>
                                    @endforeach
                                @else
                                    @foreach (months() as $month)
                                        <th>{{ $month }}</th>
                                    @endforeach
                                @endif
                                <th> Total </th>
                            </tr>
                            </thead>
                            <tbody>
                            @php
                                $i = 0;
                            @endphp
                            @foreach ($users as $user)
                                @if($user->total_amount>0)
                                    @php
                                        $i++;
                                    @endphp
                                    <tr>
                                        <td>{{ $i }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->mobile_no }}</td>
                                        @if (isset($request->month))
                                            @foreach ($request->month as $monthNo)
                                                <td>{{$user->amount[$monthNo] }}</td>
                                            @endforeach
                                        @else
                                            @foreach (months() as $monthNo => $month)
                                                <td>{{$user->amount[$monthNo] }}</td>
                                            @endforeach
                                        @endif
                                        <th style="background:#ccc">{{$user->total_amount }}</th>
                                    </tr>
                                @endif
                            @endforeach
                            <tr>
                                <th colspan="3" class="text-right"> Total:</th>
                                @if (isset($request->month))
                                    @foreach ($request->month as $monthNo)
                                        <th>{{$monthTotal[$monthNo]}}</th>
                                    @endforeach
                                @else
                                    @foreach (months() as $monthNo => $month)
                                        <th>{{$monthTotal[$monthNo]}}</th>
                                    @endforeach
                                @endif
                                <th class="bg-success" style="white-space: nowrap">= {{ $grandTotal }}</th>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script src="{{asset('assets/backend/js/jQuery.print.js')}}"></script>
    <script>
        $(function () {
            $('#printBtn').on('click', function () {
                $("#printBody").print();
            });
        });
    </script>
@endpush

