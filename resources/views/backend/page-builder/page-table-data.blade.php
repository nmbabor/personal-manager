<table class="table table-hover table-striped text-nowrap">
    <thead>
        <tr>
            <th>Image</th>
            <th>Title</th>
            <th>Slug</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($pages as $data)
            <tr>
                <td>
                    <img class="img-fluid" src="{{ $data->thumb_null }}" width="30" alt="{{ $data->title }}">
                </td>
                <td>{{ $data->title }}</td>
                <td>{{ $data->slug }}</td>
                <td>
                    @if ($data->status == 1)
                        <span class="badge badge-pill badge-success">Active</span>
                    @else
                        <span class="badge badge-pill badge-danger">Inative</span>
                    @endif
                </td>
                <td>
                    <div class="action-wrapper">
                        <a class="btn btn-xs btn-success" href="{{url('pages',$data->slug)}}" target="_blank">
                            <i class="fas fa-link"></i>
                        </a>
                        <a class="btn btn-xs btn-info" href="javascript:void(0)" onclick="load_edit_form('{{ $data->id }}')">
                            <i class="far fa-edit"></i>
                        </a>
                        <button class="btn btn-xs btn-danger" type="button"
                            onclick="confirmDelete('{{ route('backend.admin.delete.page', $data->id) }}')">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<div class="col-md-12">
    {{ $pages->links() }}
</div>

<script>
    function load_edit_form(id) {
        $.ajax({
            url: "{{ route('backend.admin.page.load.edit.form') }}?id=" + id,
            success(response) {
                $('#form_section')
                    .css('background-color', 'yellow')
                    .animate({
                        backgroundColor: 'transparent'
                    }, 1000, function() {
                        $(this).css('background-color', '');
                    });

                $('#form_section').html(response);
            }
        });
    }
</script>
