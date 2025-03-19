@extends('backend.master')

@section('title', 'Create New Blog')
@section('title_button')
<a href="{{ route('backend.admin.blogs') }}" class="btn bg-gradient-primary" >
    <i class="fas fa-list"></i>
    View All
</a>
@endsection

@section('content')
    <!-- card -->
    <div class="card">
        <!-- form start -->
        <form action="{{ route('backend.admin.blogs.create') }}" method="post" enctype="multipart/form-data"
            id="create-blog-form">
            @csrf
            <div class="card-body">
                <div class="row">
                    <div class="col-md-9">
                        <div class="form-group">
                            <label for="title"> Blog Title <span class="text-danger">*</span> : </label>
                            <input type="text" class="form-control" placeholder="Enter title" name="title"
                                value="{{ old('title') }}" required>
                        </div>
                        <div class="form-group">
                            <label for="slug"> Blog Link <span class="text-danger">*</span> : </label>
                            <input type="text" class="form-control" placeholder="Blog Link" name="slug"
                                value="{{ old('slug') }}" required>
                        </div>
                        <div class="form-group">
                            <label for="description">
                                Long Description
                                <span class="text-danger">*</span> :
                            </label>
                            <textarea class="form-control summerNote" placeholder="Enter long description" name="long_description" cols="30"
                                rows="10" id="description">{{ old('long_description') }}</textarea>
                            <p class="text-danger d-none" id="description-error">
                                * description field is required
                            </p>
                        </div>
                        <div class="form-group">
                            <label for="meta_description">
                                Meta Description
                                <span class="text-danger">*</span> :
                            </label>
                            <textarea class="form-control" placeholder="Enter meta description" name="meta_description" required cols="30"
                                rows="4">{{ old('meta_description') }}</textarea>
                        </div>
                        
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="category">
                                Category
                                <span class="text-danger">*</span> :
                            </label>
                            <select class="form-control" name="category_id" required>
                                <option value="">-- Select --</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group {{ $errors->has('thumbnail') ? 'has-error' : '' }}">
                            <label for="thumbnail"> Thumbnail <span class="text-danger">*</span> : </label>
                            <div class="col-md-12">
                                <label class="post_upload" for="file">
                                    <!--  -->
                                    <img id="image_load" src="{{asset('assets/images/photo.png')}}">
                                </label>
                                {{Form::file('thumbnail',array('id'=>'file','style'=>'display:none','onchange'=>"photoLoad(this,'image_load')"))}}
                                 @if ($errors->has('thumbnail'))
                                        <span class="help-block" style="display:block">
                                            <strong>{{ $errors->first('thumbnail') }}</strong>
                                        </span>
                                    @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="main-features">
                                Meta Tags :
                            </label>
                            <textarea class="form-control" placeholder="SPA,Hosting, ..." name="meta_tags"
                                value="{{ old('meta_tags') }}"></textarea>
                            <small class="form-text text-muted">Enter values separated by commas.</small>
                        </div>
                        <div class="form-group">
                            <div class="py-1 custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                <input type="checkbox" class="custom-control-input" id="publish" name="status" checked>
                                <label class="custom-control-label" for="publish">
                                    Publish
                                </label>
                            </div>
                        </div>
                        <button type="submit" class="btn bg-gradient-primary">Submit</button>
                    </div>
                </div>

            </div>
        </form>
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
