@extends('backend.master')

@section('title', 'Projects')
@section('title_button')
    <a href="{{ route('projects.create') }}" class="btn bg-primary" >
        <i class="fas fa-plus-circle"></i>
        Add New
    </a>
@endsection
@section('content')
    <div class="card">
        <div class="card-body p-2 p-md-4 pt-0">
            <div class="row g-4">
                <div class="col-md-12">
                    <div class="card-body table-responsive p-0" id="table_data">
                        <table id="datatables" class="table table-hover">
                            <thead>
                                <tr>
                                    <th data-orderable="false">#</th>
                                    <th>Title</th>
                                    <th>Address</th>
                                    <th>Reference</th>
                                    <th>Collection</th>
                                    <th>Expense</th>
                                    <th>Status</th>
                                    <th data-orderable="false">
                                        Action
                                    </th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script type="text/javascript">
        $(function() {
            let table = $('#datatables').DataTable({
                processing: true,
                serverSide: true,
                ordering: true,
                order: [
                    [1, 'asc']
                ],
                ajax: {
                    url: "{{ route('projects.index') }}"
                },

                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                    }, {
                        data: 'title',
                        name: 'title'
                    },
                    {
                        data: 'address',
                        name: 'address'
                    },
                    {
                        data: 'reference',
                        name: 'reference'
                    },
                    {
                        data: 'total_income',
                        name: 'total_income'
                    },
                    {
                        data: 'total_expense',
                        name: 'total_expense'
                    },
                    
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'action',
                        name: 'action'
                    },
                ]
            });
        });
    </script>
@endpush
