@extends('backend.master')

@section('title', 'Monthly Collection')
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
                                @php
                                    $i++;
                                @endphp
                                @if($user->total_amount>0)
                                <tr>
                                    <td>{{ $i++ }}</td>
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
                                    <th  style="background:#ccc">{{$user->total_amount }}</th>
                                </tr>
                                @endif
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="3" class="text-right"> Total: </th>
                                @if (isset($request->month))
                                    @foreach ($request->month as $monthNo)
                                        <th>{{$monthTotal[$monthNo]}}</th>
                                    @endforeach
                                @else
                                    @foreach (months() as $monthNo => $month)
                                        <th>{{$monthTotal[$monthNo]}}</th>
                                    @endforeach
                                @endif
                                <th class="bg-success">= {{ $grandTotal }}</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
