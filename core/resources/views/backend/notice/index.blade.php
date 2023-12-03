@extends('backend.master')

@section('title', 'Notices')
@section('title_button')
<a href="{{ route('manage-notice.create') }}" class="btn bg-gradient-primary" >
    <i class="fas fa-plus"></i>
    Add New
</a>
@endsection

@section('content')
    <div class="card">
        <div class="card-body table-responsive">
            <table id="datatables" class="table table-hover">
                <thead>
                    <tr>
                        <th data-orderable="false">#</th>
                        <th>Title</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th data-orderable="false">
                            Action
                        </th>
                    </tr>
                </thead>
            </table>
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
                    url: "{{ route('manage-notice.index') }}"
                },

                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                    }
                    , {
                        data: 'title',
                        name: 'title'
                    },
                    {
                        data: 'notice_date',
                        name: 'notice_date'
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
