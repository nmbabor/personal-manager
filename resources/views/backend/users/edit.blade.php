@extends('backend.master')

@section('title', 'Update Member')
@section('title_button')
    <a href="{{ route('backend.admin.user.create') }}" class="btn bg-gradient-primary" >
        <i class="fas fa-plus-circle"></i>
        Add New
    </a>
    <a href="{{ route('backend.admin.users') }}" class="btn bg-gradient-primary" >
        <i class="fas fa-list"></i>
        View All
    </a>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('backend.admin.user.edit', $user->id) }}" method="post" class="accountForm"
                enctype="multipart/form-data">
                @csrf
                <div class="row g-4">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="fullName" class="form-label">Full Name<span class="text-danger">*</span> : </label>
                            <input type="text" class="form-control" id="fullName" placeholder="Enter full name"
                                name="name" value="{{ $user->name }}" required>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="email" class="form-label">Email<span class="text-danger">*</span> :</label>
                            <input type="text" class="form-control" id="email" placeholder="Email" name="email"
                                value="{{ $user->email }}" required>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="mobileNumber" class="form-label">Mobile Number<span class="text-danger">*</span> :</label>
                            <input type="number" min="0" class="form-control" id="mobileNumber" placeholder="Mobile Number"
                                name="mobile_no" value="{{ $user->mobile_no }}" required>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="type" class="form-label">User Type<span class="text-danger">*</span> :</label>
                            {{Form::select('type',['Admin'=>'Admin','User'=>'User'],$user->type,['class'=>'form-control','placeholder'=>'Select Type', 'required'])}}
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="thumbnail">Profile Image :</label>
                            <input type="file" class="form-control" name="profile_image"
                                onchange="previewThumbnail(this)">
                                <img class="img-fluid thumbnail-preview" src="{{ $user->profile_image != '' ? $user->pro_pic : nullImg() }}" alt="preview-image" style="height: 100px">
                        </div>
                    </div>
                </div>
                <div class="row g-4">
                    <div class="col-3">
                        <button type="submit" class="btn btn-block bg-gradient-primary">Save Change</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
