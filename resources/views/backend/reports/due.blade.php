@extends('backend.master')

@section('title', 'Due Reports')
@section('title_button')
    <button class="btn btn-sm btn-info" id="printBtn"><i class="fa fa-print"></i> Print</button>
@endsection
@section('content')
    <div class="card">
        <div class="card-body">
            <form action="" class="d-flex justify-content-center">
                <div class="col-md-3">
                    <div class="input-group mb-3">
                        {{Form::select('country',$country,$selectedCountry??'',['class'=>'form-control select2','placeholder'=>'All Country'])}}
                        <button class="btn btn-outline-secondary" type="submit" id="button-addon2">Find</button>
                      </div>
                </div>
            </form>
            <div class="row">
                <div class="print-body" id="printBody">
                    <style>
                        .print-body{
                            width: 900px;
                            background: #fff;
                            margin: 5px auto;
                        }
                        .print-body .row{
                            margin: 0;
                        }
                        .print-only{display: none}

                        @page{
                            margin: 10px 0px 10px 0px;
                            size: A4 portrait;
                        }
                        @media print {
                            html, body {
                                width: 100%;
                                height: 100vh;
                            }
                            .print-body{
                                width: 98%;
                            }
                            .print-none{
                                display: none;
                            }
                            .print-only{display: inline}
                        }
                    </style>
                <div class="col-md-12 table-responsive">
                    <table class="table table-bordered table-striped table-hover table-min-padding">
                        <thead>
                            <tr>
                                <th colspan="5" style="text-align: center;"> ৭ নং ধর্মপুর ইউনিয়ন প্রবাসী কল্যাণ ট্রাষ্ট <br> মাসিক চাঁদা বকেয়া হিসাব </th>
                            </tr>
                            <tr>
                                <th width="2%">#</th>
                                <th>সদস্যের নাম</th>
                                <th> চাঁদা </th>
                                <th> বকেয়া মাস </th>
                                <th class="text-center print-none">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $i = 0; @endphp
                            @foreach ($users as $user)
                                @if (count($user->dueMonths()) > 0)
                                    @php $i++; @endphp
                                    <tr>
                                        <td>{{ $i }}</td>
                                        <td @if (count($user->dueMonths()) > 4) class="text-danger" @endif>{{ $user->name }}</td>
                                        <td>{{ $user->monthly_amount }}</td>
                                        <td>
                                            ({{count($user->dueMonths())}})
                                            @foreach ($user->dueMonths() as $dKey => $due)
                                                <span class="badge badge-danger print-none"> {{ date('M, Y', strtotime($due)) }} </span>
                                                <span class="print-only"> @if($dKey>0) , @endif {{ date('M - Y', strtotime($due)) }} </span>
                                            @endforeach
                                        </td>
                                        <td class="print-none"><a href="{{ route('deposit.user-details', $user->id) }}" class="btn btn-info py-0 px-1"> <i
                                                    class="fa fa-eye"></i> </a> </td>
                                    </tr>
                                @endif
                            @endforeach

                        </tbody>
                    </table>
                </div>
                </div>
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


