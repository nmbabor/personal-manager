@extends('backend.master')

@section('title', 'Due Reports')
@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row">

                <div class="col-md-12 table-responsive">
                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th width="2%">#</th>
                                <th>Member Name</th>
                                <th>Country</th>
                                <th>Mobile No</th>
                                <th>Amount</th>
                                <th>Due Month</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $i = 0; @endphp
                            @foreach ($users as $user)
                                @if (count($user->dueMonths()) > 0)
                                    @php $i++; @endphp
                                    <tr>
                                        <td>{{ $i }}</td>
                                        <td @if (count($user->dueMonths()) > 3) class="text-danger" @endif>{{ $user->name }}</td>
                                        <td>{{ $user->country->name ?? '' }}</td>
                                        <td>{{ $user->mobile_no }}</td>
                                        <td>{{ $user->monthly_amount }}</td>
                                        <td>
                                            ({{count($user->dueMonths())}})
                                            @foreach ($user->dueMonths() as $due)
                                                <span class="badge badge-danger"> {{ date('M, Y', strtotime($due)) }} </span>
                                            @endforeach
                                        </td>
                                        <td><a href="{{ route('deposit.user-details', $user->id) }}" class="btn btn-info"> <i
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
@endsection

