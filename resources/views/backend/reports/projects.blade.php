@extends('backend.master')

@section('title', 'Projects Reports')
@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row mb-2">
                <div class="col-md-2">
                <form action="{{ route('reports.projects') }}">

                        <div class="input-group mb-3">
                            {{ Form::select('year', $yearsArray, $request->year ?? '', ['class' => 'form-control', 'placeholder' => 'All Year']) }}
                            <button class="btn btn-secondary" type="submit" id="button-addon2">Find</button>
                        </div>

                    </form>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 table-responsive">
                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr class="bg-info">
                                <th width="2%">#</th>
                                <th>Title</th>
                                <th>Address</th>
                                @if(Auth::user()->type == 'Admin')
                                <th>Collection</th>
                                <th>Regular Fund</th>
                                @endif
                                <th>Expense</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $i = 0;
                                $totalCollection = 0;
                                $totalExpense = 0;
                                $totalRegularFund = 0;
                            @endphp
                            @foreach ($projects as $project)
                                @php
                                    $i++;
                                    $regularFund = $project->totalIncome() - $project->totalExpense();
                                    $totalCollection +=$project->totalIncome();
                                    $totalExpense +=$project->totalExpense();
                                    $totalRegularFund += $regularFund;
                                @endphp

                                <tr>
                                    <td>{{ $i }}</td>
                                    <td>{{ $project->title }}</td>
                                    <td>{{ $project->address }}</td>
                                    @if(Auth::user()->type == 'Admin')
                                    <td>{{ $project->totalIncome() }}</td>
                                    <td>
                                        @if ($regularFund < 0)
                                            <i class="fa fa-minus-circle text-danger"></i> {{ $regularFund * -1 }}
                                        @elseif($regularFund > 0)
                                            <i class="fa fa-plus-circle text-success"></i> {{ $regularFund }}
                                        @endif
                                    </td>
                                    @endif
                                    <td>{{ $project->totalExpense() }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr style="background:#ccc">
                                <th colspan="3" class="text-right"> Total: </th>
                                @if(Auth::user()->type == 'Admin')
                                <th>{{$totalCollection}}</th>
                                <th>
                                    @if ($totalRegularFund < 0)
                                        <i class="fa fa-minus-circle text-danger"></i> {{ $totalRegularFund * -1 }}
                                    @elseif($totalRegularFund > 0)
                                        <i class="fa fa-plus-circle text-success"></i> {{ $totalRegularFund }}
                                    @endif
                                </th>
                                @endif
                                <th>{{$totalExpense}}</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
