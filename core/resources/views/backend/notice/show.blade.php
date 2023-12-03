@extends('backend.master')

@section('title', $data->title)
@section('title_button')
    <button class="btn btn-sm btn-info" id="printBtn"><i class="fa fa-print"></i> Print</button>
    <a href="{{ route('manage-notice.index') }}" class="btn btn-sm bg-gradient-primary">
        <i class="fas fa-list"></i>
        View All
    </a>
@endsection

@section('content')
    <!-- card -->
    <div class="card" style="background: #f0f8ff">
        {{--<div class="col-md-12">
            <p> <b>Date:</b> {{ date('d-m-Y',strtotime($data->notice_date)) }} </p>
        </div>--}}
        <div class="row">
            <div class="col-md-12">
                <div class="print-body" id="printBody">
                    <style>
                        .print-body{
                            width: 210mm;
                            background: #fff;
                            margin: 5px auto;
                            border: 1px solid #ccc;
                        }
                        .print-body .row{
                            margin: 0;
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
                        .print-content{
                            padding: 15px 40px;
                            position: relative;
                            min-height: 600px;
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
                        }
                        .watermark img {
                            width: 400px;
                            opacity: .07;
                            margin: 0 auto;
                        }
                        @page{
                            margin: 0 0 0 0;
                            size: A4 portrait;
                        }
                        @media print {
                            html, body {
                                width: 100%;
                            }
                            .print-body{
                                width: 98%;
                                min-height: 367mm;
                                border: 1px solid #ccc;
                            }
                            .watermark {
                                height: 100vh;
                            }
                            .watermark img {
                                width: 700px;
                            }
                        }
                    </style>
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

                    <div class="print-content">
                        <div class="watermark">
                            <img src="{{ imageRecover(readconfig('site_logo')) }}">
                        </div>

                        {!! $data->details !!}
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- /.card -->
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
