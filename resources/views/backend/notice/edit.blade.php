@extends('backend.master')

@section('title', 'Update Notice')
@section('title_button')
    <a href="{{ route('manage-notice.index') }}" class="btn bg-gradient-primary">
        <i class="fas fa-list"></i>
        View All
    </a>
@endsection

@section('content')
    <!-- card -->
    <div class="card">
        <!-- form start -->
        {!! Form::open(['method' => 'put', 'route' => ['manage-notice.update', $data->id],'id'=>'create-blog-form']) !!}
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="title"> Title <span class="text-danger">*</span> : </label>
                        <input type="text" class="form-control" placeholder="Enter title" name="title"
                               value="{{ $data->title }}" required>
                    </div>
                    <div class="form-group">
                        <label for="slug"> Date <span class="text-danger">*</span> : </label>
                        <input type="text" class="form-control singleDatePicker" placeholder="Date" name="notice_date"
                               value="{{ date('d-m-Y',strtotime($data->notice_date)) }}" required>
                    </div>
                    <div class="form-group">
                        <label for="details">
                            Description
                            <span class="text-danger">*</span> :
                        </label>
                        <textarea class="form-control summerNote" placeholder="Enter long description" name="details"
                                  cols="30"
                                  rows="10" id="details">{{ $data->details }}</textarea>
                        <p class="text-danger d-none" id="description-error">
                            * description field is required
                        </p>
                    </div>
                    <div class="form-group">
                        <div
                            class="py-1 custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                            <input type="checkbox" class="custom-control-input" id="publish" name="status"
                                {{ $data->status ? 'checked' : '' }}>
                            <label class="custom-control-label" for="publish">
                                Publish
                            </label>
                        </div>
                    </div>
                    <button type="submit" class="btn bg-gradient-primary">Update</button>
                </div>
            </div>

        </div>
        {!! Form::close() !!}
    </div>
    <!-- /.card -->
@endsection

@push('script')
    <script>
        document
            .getElementById("create-blog-form")
            .addEventListener("submit", function (event) {
                var contentValue = document.getElementById("description").value;

                if (contentValue.trim() === "") {
                    event.preventDefault();

                    // Throw an exception or display an error message
                    document.getElementById("description-error").classList.remove("d-none");
                }
            });
    </script>
@endpush
