@extends('backend.master')

@section('title', 'Profile')

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('user.update.profile') }}" method="post" class="accountForm" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="row g-4">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="fullName" class="form-label">Full Name</label>
                                    <input type="text" class="form-control" id="fullName" placeholder="Enter full name"
                                        name="name" value="{{ $user->name }}">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="text" class="form-control" id="email" placeholder="Email"
                                        name="email" value="{{ $user->email }}">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="thumbnail">Profile Image</label>
                                    <input type="file" class="form-control" name="profile_image"
                                        onchange="previewThumbnail(this)">
                                    <img class="img-fluid thumbnail-preview mt-2" style="width: 100px; height:auto"
                                        src="{{ auth()->user()->pro_pic }}" alt="preview-image">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h4 class="font-weight-bold">Password {{$user->is_google_registered?'set':'change'}}</h4>
                        <div class="row g-4">
                            @if(!$user->is_google_registered)
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="password" class="form-label">Current password</label>
                                    <input type="password" class="form-control" id="password"
                                        placeholder="Enter your password" name="current_password"
                                        autocomplete="new-password">
                                </div>
                            </div>
                            @endif
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="newPassword" class="form-label">New Password</label>
                                    <input type="password" class="form-control" id="newPassword"
                                        placeholder="Password" name="password">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="confirmPassword" class="form-label">Confirm password</label>
                                    <input type="password" class="form-control" id="confirmPassword"
                                        placeholder="Confirm password" name="password_confirmation">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group text-center">
                            <button type="submit" class="btn bg-gradient-primary"> <i class="fa fa-save"></i> Update</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
