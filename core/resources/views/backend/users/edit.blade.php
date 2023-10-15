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
                            <label for="country_id" class="form-label">Country<span class="text-danger">*</span> :</label>
                            {{Form::select('country_id',$country,$user->country_id,['class'=>'form-control select2','placeholder'=>'Select Country', 'required'])}}
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="monthly_amount" class="form-label">Monthly Deposit<span class="text-danger">*</span> :</label>
                            <input type="number" min="0" class="form-control" id="monthly_amount" placeholder="Ex: 500"
                                name="monthly_amount" value="{{$user->monthly_amount}}" required>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="word_no" class="form-label">Word No<span class="text-danger">*</span> :</label>
                            {{Form::select('word_no',$words,$user->word_no,['class'=>'form-control','placeholder'=>'Select Word', 'required'])}}
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="join_date" class="form-label">Join Date <span class="text-danger">*</span> : </label>
                            <input type="text" class="form-control singleDatePicker" id="join_date" placeholder=""
                                name="join_date" value="{{ date('d-m-Y',strtotime($user->join_date)) }}">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="deposit_start_date" class="form-label">Deposit Start Date <span class="text-danger">*</span> : </label>
                            <input type="text" class="form-control singleDatePicker" id="deposit_start_date" placeholder=""
                                name="deposit_start_date" value="{{ date('d-m-Y',strtotime($user->deposit_start_date)) }}">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="father_name" class="form-label">Father's Name : </label>
                            <input type="text" class="form-control" id="father_name" placeholder="Enter Father Name"
                                name="father_name" value="{{ $user->father_name }}">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="mother_name" class="form-label">Mother's Name : </label>
                            <input type="text" class="form-control" id="mother_name" placeholder="Enter Mother Name"
                                name="mother_name" value="{{ $user->mother_name }}">
                        </div>
                    </div>
                     <div class="col-lg-6">
                        <div class="form-group">
                            <label for="permanent_address" class="form-label">Permanent Address : </label>
                            <input type="text" class="form-control" id="permanent_address" placeholder="Enter Father Name"
                                name="permanent_address" value="{{ $user->permanent_address }}">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="peresent_address" class="form-label">Present Address : </label>
                            <input type="text" class="form-control" id="peresent_address" placeholder="Enter Mother Name"
                                name="peresent_address" value="{{ $user->peresent_address }}">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="designation" class="form-label">Designation : </label>
                            <input type="text" class="form-control" id="designation" placeholder="Enter Mother Name"
                                name="designation" value="{{$user->designation}}">
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
