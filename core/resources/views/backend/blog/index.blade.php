@extends('backend.master')

@section('title', 'Blogs')
@section('title_button')
<a href="{{ route('backend.admin.blogs.create') }}" class="btn bg-gradient-primary" >
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
                        <th>Category</th>
                        <th>Status</th>
                        <th>Created</th>
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
                    url: "{{ route('backend.admin.blogs') }}"
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
                        data: 'category_name',
                        name: 'blog_categories.title',
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'created',
                        name: 'created_at',
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