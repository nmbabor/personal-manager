@extends('backend.master')

@section('title', 'Dashboard')

@section('content')
    <section class="content">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>0</h3>
                            <p>Today Submited Links</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>
                        <a href="#" class="small-box-footer">
                            More info
                            <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>0</h3>
                            <p>Total Submited Links</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="#" class="small-box-footer">
                            More info
                            <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{ $totalTransections}}</h3>
                            <p>Total Transections Amount</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person-add"></i>
                        </div>
                        <a href="#" class="small-box-footer">
                            More info
                            <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>BDT 0</h3>
                            <p>Today Transections Amount</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-pie-graph"></i>
                        </div>
                        <a href="#" class="small-box-footer">
                            More info
                            <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
                <!-- ./col -->
            </div>
            <!-- /.row -->


            <div class="row">
                <!-- Left col -->
                <div class="col-md-12">

                    <!-- TABLE: LATEST ORDERS -->
                    <div class="card">
                        <div class="card-header border-transparent">
                            <h3 class="card-title">Latest Transections</h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="remove">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table m-0">
                                    <thead>
                                        <tr>
                                            <th>Invoice</th>
                                            <th>Plan</th>
                                            <th>Amount</th>
                                            <th>User</th>
                                            <th>Method</th>
                                            <th>Status</th>
                                            <th>Created At</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                       {{--  @foreach($recentOrders as $order)
                                        <tr>
                                            <td><a href="{{route('user.transections.show',$order->id)}}">{{$order->invoice_no}}</a></td>
                                            <td>{{$order->plan->title ?? ''}}</td>
                                            <td>{{$order->total_amount}}</td>
                                            <td>{{$order->user->email ??''}}</td>
                                            <td>{{$order->payment_method}}</td>
                                            <td>
                                                @if($order->is_paid == 1)
                                                    <span class="badge badge-success"> Paid</span>
                                                @else 
                                                    <span class='badge bg-warning'>Pending</span>
                                                @endif
                                            </td>
                                            <td>
                                                {{date('d M, Y', strtotime($order->created_at))}}
                                            </td>
                                        </tr>
                                        @endforeach --}}
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.table-responsive -->
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer clearfix">
                            <a href="#" class="btn btn-sm btn-secondary float-right">View All Transections</a>
                        </div>
                        <!-- /.card-footer -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>

        </div><!-- /.container-fluid -->
    </section>
@endsection
