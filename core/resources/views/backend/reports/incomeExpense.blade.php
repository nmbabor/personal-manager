@extends('backend.master')

@section('title', 'Income Expense')
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
            <div class="row">
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
                <div class="col-md-6">
                    <label class="bg-success form-control text-right"> অবশিষ্ট এমাউন্ট : <b
                            style="font-size: 20px">{{ $totalIncome - $totalExpense }} </b> </label>
                    @if(Auth::user()->type == 'Admin')
                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#myModal">
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
        </div>
    </div>
@endsection
