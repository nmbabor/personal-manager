@extends('backend.master')

@section('title', 'Blog Category')
@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-5 border-right">
                    <fieldset>
                        <form action="{{ route('categories.store') }}" method="post" id="addNewData">
                            @csrf
                            <div class="form-group">
                                <label class="col-md-12"> Name <span class="text-danger">*</span> : </label>
                                <div class="col-md-12">
                                    <input type="text" class="form-control" placeholder="Name" name="title">
                                    @error('title')
                                        <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-12"> Slug <span class="text-danger">*</span> : </label>
                                <div class="col-md-12">
                                    <input type="text" class="form-control" placeholder="Slug" name="slug">
                                    @error('slug')
                                        <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-12">Meta Description : </label>
                                <div class="col-md-12">
                                    <textarea class="form-control" placeholder="Meta Description" name="description"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-12">Meta Keywords : </label>
                                <div class="col-md-12">
                                    <textarea class="form-control" placeholder="Meta Keywords" name="keywords"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-12">
                                    <button type="submit" class="btn bg-gradient-primary">
                                        Submit
                                    </button>
                                </div>
                            </div>
                            
                        </form>
                    </fieldset>
                    <hr>
                </div>

                <div class="col-md-7 table-responsive">
                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th colspan="2">Name</th>
                                <th>Slug</th>
                                <th width="5%">Status</th>
                                <th class="text-center" width="20%">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($allData as $data)
                                <tr>
                                    <td colspan="2" >{{ $data->title }}</td>
                                    <td>{{ $data->slug }}</td>
                                    <td>
                                        @if($data->status==1)
                                        <span class="badge badge-success" title="Active"> <i class="fa fa-check"></i> </span>
                                        @else
                                        <span class="badge badge-danger" title="Inactive"> <i class="fa fa-times"></i> </span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="text-center">
                                            <!-- Button trigger modal -->
                                            <button title="Edit Category" type="button" class="btn btn-info btn-xs"
                                                data-toggle="modal" data-target="#editCategory-{{ $data->id }}">
                                                <i class="fas fa-pencil-alt"></i>
                                            </button>
                                            <a class="btn btn-danger btn-xs" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Delete Category"
                                                                href="javascript:void(0)"
                                                                onclick='resourceDelete("{{ route('categories.destroy', $data->id) }}")'>
                                                                <span class="delete-icon">
                                                <i class="fas fa-trash-alt"></i>
                                            </a>
                                        </div>

                                        <!-- Modal -->
                                        <div class="modal fade" id="editCategory-{{ $data->id }}" tabindex="-1"
                                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                {!! Form::open(['method' => 'put', 'route' => ['categories.update', $data->id]]) !!}
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title fs-5" id="exampleModalLabel">
                                                            <i class="fas fa-pencil-alt"></i>
                                                            Edit Category
                                                        </h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label class="control-label">Name:</label>
                                                            {!! Form::text('title', $data->title, ['class' => 'form-control', 'placeholder' => 'Name','required']) !!}
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label">Slug:</label>
                                                            {!! Form::text('slug', $data->slug, ['class' => 'form-control', 'placeholder' => 'Slug', 'required']) !!}
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label"> Meta Description : </label>
                                                            <textarea class="form-control" placeholder="Meta Description" name="description">{{$data->description}}</textarea>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label">Meta Keywords : </label>
                                                            <textarea class="form-control" placeholder="Meta Keywords" name="keywords">{{$data->keywords}}</textarea>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label">Status:</label>
                                                            {!! Form::select('status',[1=>'Active', 0 =>'Inactive'], $data->status, ['class' => 'form-control','required']) !!}
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn bg-gradient-secondary"
                                                            data-dismiss="modal">
                                                            Close
                                                        </button>
                                                        <button type="submit" class="btn bg-gradient-primary">
                                                            Save changes
                                                        </button>
                                                    </div>
                                                </div>
                                                {!! Form::close() !!}
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
 <script>
    function getSlugFromString(str) {
    return str
        .toLowerCase()
        .replace(/[^a-z0-9-]/g, "-")
        .replace(/-+/g, "-")
        .replace(/^-|-$/g, "");
    }

    $("#addNewData [name='title']").keyup(function () {
    $("#addNewData [name='slug']").val(getSlugFromString(this.value));
    });
 </script>
@endpush

