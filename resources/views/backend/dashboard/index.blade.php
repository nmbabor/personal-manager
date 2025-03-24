@extends('backend.master')

@section('content')
    <section class="content">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <!-- small box -->
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ en2bn($totalCustomers) }} <small>জন </small></h3>
                            <p>মোট গ্রাহক সংখ্যা</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person"></i>
                        </div>
                        @if(Auth::user()->type == 'Admin')
                            <a href="{{ route('customers.index') }}" class="small-box-footer">
                                <i class="fas fa-users"></i>
                                সকল গ্রাহক দেখুন
                            </a>
                        @endif
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <!-- small box -->
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>৳ {{ en2bn(number_format(12)) }}</h3>
                            <p>{{ en2bn(date('F, Y')) }} এর মোট জমা</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        @if(Auth::user()->type == 'Admin')
                            <a href="{{route('reports.monthly-collection')}}" class="small-box-footer">
                               বিস্তারিত দেখুন
                                <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        @endif
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <!-- small box -->
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>৳ {{ en2bn(number_format(6)) }}</h3>
                            <p>{{ en2bn(date('F, Y')) }} এর মোট বাকি</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        @if(Auth::user()->type == 'Admin')
                            <a href="{{ route('backend.admin.user.create') }}" class="small-box-footer">
                                বিস্তারিত দেখুন <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        @endif
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <!-- small box -->
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>৳ {{ en2bn(number_format($totalDue)) }}</h3>
                            <p> বর্তমান বাকি </p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-pie-graph"></i>
                        </div>
                        @if(Auth::user()->type == 'Admin')
                            <a href="{{route('reports.projects')}}" class="small-box-footer">
                                বিস্তারিত দেখুন
                                <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        @endif
                    </div>
                </div>
                <!-- ./col -->
            </div>
            <!-- /.row -->

            <div class="row">
                <div class="col-md-12">
                <div class="card">
              <div class="card-header d-flex p-0">
                <ul class="nav nav-pills mr-auto p-2">
                  <li class="nav-item"><a class="nav-link active" href="#tab_1" data-toggle="tab">আজকের বাকি</a></li>
                  <li class="nav-item"><a class="nav-link" href="#tab_2" data-toggle="tab">আজকের জমা</a></li>
                </ul>
                <h3 class="card-title p-3">আজঃ {{en2bn(date('d F, Y'))}} ইং </h3>
                <div class="card-tools p-3">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content">
                  <div class="tab-pane active" id="tab_1">
                    <table class="table table-bordered table-striped table-hover table-min-padding">
                        <thead>
                        <tr>
                            <th width="3%" class="text-center">#</th>
                            <th>গ্রাহকের নাম ও ঠিকানা </th>
                            <th>পণ্যের বিবরণ</th>
                            <th class="text-right"> বাকি টাকা</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($dueList as $dueKey => $due)
                            <tr>
                                <td class="text-center">{{$dueKey+1}}</td>
                                <td> <b> <a href="{{route('customers.show',$due->customer->id)}}"> {{$due->customer->name??''}} </a> </b> <br> {{$due->customer->address??''}} </td>
                                <td> {{$due->details}} </td>
                                <td class="text-right"> {{en2bn($due->amount)}}/- </td>
                            </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="bg-light-success">
                                <th class="text-right" colspan="3"> আজকের মোট বাকিঃ </th>
                                <th class="text-right"> {{en2bn($dueList->sum('amount'))}}/- </th>
                            </tr>
                        </tfoot>
                    </table>
                  </div>
                  <!-- /.tab-pane -->
                  <div class="tab-pane" id="tab_2">
                  <table class="table table-bordered table-striped table-hover table-min-padding">
                        <thead>
                        <tr>
                            <th width="3%" class="text-center">#</th>
                            <th>গ্রাহকের নাম ও ঠিকানা </th>
                            <th> বিবরণ</th>
                            <th class="text-right"> জমা টাকা</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($depositList as $depositKey => $deposit)
                            <tr>
                                <td class="text-center">{{$depositKey+1}}</td>
                                <td> <b> <a href="{{route('customers.show',$deposit->customer->id)}}"> {{$deposit->customer->name??''}} </a> </b> <br> {{$deposit->customer->address??''}} </td>
                                <td> {{$deposit->details}} </td>
                                <td class="text-right"> {{en2bn($deposit->amount)}}/- </td>
                            </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="bg-light-success">
                                <th class="text-right" colspan="3"> আজকের মোট জমাঃ </th>
                                <th class="text-right"> {{en2bn($depositList->sum('amount'))}}/- </th>
                            </tr>
                        </tfoot>
                    </table>
                  </div>
                    <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
              </div><!-- /.card-body -->
            </div>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
@endsection
