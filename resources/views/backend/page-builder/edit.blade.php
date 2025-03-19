@extends('backend.master')

@section('title', 'Update Page')
@section('title_button')
<a href="{{ route('page-builder.index') }}" class="btn bg-gradient-primary" >
    <i class="fas fa-list"></i>
    View All
</a>
@endsection

@section('content')
    <!-- card -->
    <div class="card">
        <!-- form start -->
        {!! Form::open(['method' => 'put', 'route' => ['page-builder.update', $data->id],'id'=>'create-blog-form']) !!}
            <div class="card-body">
                <div class="row">
                    <div class="col-md-9">
                        <div class="form-group">
                            <label for="title"> Page Title <span class="text-danger">*</span> : </label>
                            <input type="text" class="form-control" placeholder="Enter title" name="title"
                                value="{{ $data->title }}" required>
                        </div>
                        <div class="form-group">
                            <label for="slug"> Page Link <span class="text-danger">*</span> : </label>
                            <input type="text" class="form-control" placeholder="Page Link" name="slug"
                                value="{{ $data->slug }}" required>
                        </div>
                        <div class="form-group">
                            <label for="content">
                                Long Description
                                <span class="text-danger">*</span> :
                            </label>
                            <textarea class="form-control summerNote" placeholder="Enter long description" name="content" cols="30"
                                rows="10" id="content">{{ $data->content }}</textarea>
                            <p class="text-danger d-none" id="description-error">
                                * description field is required
                            </p>
                        </div>
                        
                        
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="meta_description">
                                Meta Description
                                <span class="text-danger">*</span> :
                            </label>
                            <textarea class="form-control" placeholder="Enter short description for meta description" name="meta_description" required cols="30"
                                rows="4">{{ $data->meta_description }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="main-features">
                                Meta Tags :
                            </label>
                            <textarea class="form-control" placeholder="SPA,Hosting, ..." name="meta_tags">{{ $data->meta_tags }}</textarea>
                            <small class="form-text text-muted">Enter values separated by commas.</small>
                        </div>
                        <div class="form-group">
                            <div class="py-1 custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
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
            .addEventListener("submit", function(event) {
                var contentValue = document.getElementById("description").value;

                if (contentValue.trim() === "") {
                    event.preventDefault();

                    // Throw an exception or display an error message
                    document.getElementById("description-error").classList.remove("d-none");
                }
            });

            function getSlugFromString(str) {
                return str
                    .toLowerCase()
                    .replace(/[^a-z0-9-]/g, "-")
                    .replace(/-+/g, "-")
                    .replace(/^-|-$/g, "");
                }

                $("[name='title']").keyup(function () {
                    $("[name='slug']").val(getSlugFromString(this.value));
                });
    </script>
@endpush
