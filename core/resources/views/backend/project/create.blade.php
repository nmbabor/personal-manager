@extends('backend.master')

@section('title', 'Projects')
@section('title_button')
    <a href="{{ route('projects.index') }}" class="btn bg-primary">
        <i class="fas fa-list"></i>
        View All
    </a>
@endsection
@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-5 border-right">
                    <fieldset>
                        <form action="{{ route('projects.store') }}" method="post" id="addNewData">
                            @csrf
                            <div class="form-group">
                                <label class="col-md-12"> Title <span class="text-danger">*</span> : </label>
                                <div class="col-md-12">
                                    <input type="text" class="form-control" placeholder="Title" name="title">
                                    @error('title')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    @error('slug')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-12"> Address : </label>
                                <div class="col-md-12">
                                    <input type="text" class="form-control" placeholder="Address" name="address">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-12"> Reference : </label>
                                <div class="col-md-12">
                                    <input type="text" class="form-control" placeholder="Reference" name="reference">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-12">Description : </label>
                                <div class="col-md-12">
                                    <textarea class="form-control" placeholder="Description" name="details"></textarea>
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
                                <th>Title</th>
                                <th>Address</th>
                                <th width="5%">Status</th>
                                <th class="text-center" width="20%">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($allData as $data)
                                <tr>
                                    <td>{{ $data->title }}</td>
                                    <td>{{ $data->address }}</td>
                                    <td>
                                        @if ($data->status == 1)
                                            <span class="badge badge-success" title="Completed"> <i class="fa fa-check"></i>
                                            </span>
                                        @elseif($data->status == 0)
                                            <span class="badge badge-danger" title="Rejected"> <i class="fa fa-times"></i>
                                            </span>
                                        @else
                                            <span class="badge badge-warning" title="Pending"> Pending </span>
                                        @endif
                                    </td>
                                    <td>

                                        <div class="text-center">
                                            <a class="btn btn-primary btn-xs"
                                                href="{{ route('projects.show', $data->id) }}"><i class="fa fa-eye"></i></a>
                                            <!-- Button trigger modal -->
                                            <button title="Edit Project" type="button" class="btn btn-info btn-xs"
                                                data-toggle="modal" data-target="#editProject-{{ $data->id }}">
                                                <i class="fas fa-pencil-alt"></i>
                                            </button>
                                            @if ($data->isEditable())
                                                <a class="btn btn-danger btn-xs" data-bs-toggle="tooltip"
                                                    data-bs-placement="top" data-bs-title="Delete Data"
                                                    href="javascript:void(0)"
                                                    onclick='resourceDelete("{{ route('projects.destroy', $data->id) }}")'>
                                                    <span class="delete-icon">
                                                        <i class="fas fa-trash-alt"></i>
                                                </a>
                                            @endif
                                        </div>
                                        <!-- Modal -->
                                        <div class="modal fade" id="editProject-{{ $data->id }}" tabindex="-1"
                                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                {!! Form::open(['method' => 'put', 'route' => ['projects.update', $data->id]]) !!}
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title fs-5" id="exampleModalLabel">
                                                            <i class="fas fa-pencil-alt"></i>
                                                            Edit Project
                                                        </h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label class="control-label">Title:</label>
                                                            {!! Form::text('title', $data->title, ['class' => 'form-control', 'placeholder' => 'Title', 'required']) !!}
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label"> Address : </label>
                                                            <input type="text" class="form-control" placeholder="Address"
                                                                name="address" value="{{ $data->address }}">
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label"> Reference : </label>
                                                            <input type="text" class="form-control"
                                                                placeholder="Reference" name="reference"
                                                                value="{{ $data->reference }}">
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label"> Description : </label>
                                                            <textarea class="form-control" placeholder="Description" name="details">{{ $data->details }}</textarea>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label">Status:</label>
                                                            {!! Form::select('status', [2 => 'Pending', 1 => 'Completed', 0 => 'Reject'], $data->status, [
                                                                'class' => 'form-control',
                                                                'required',
                                                            ]) !!}
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
