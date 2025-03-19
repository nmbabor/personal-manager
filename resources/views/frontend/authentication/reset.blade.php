@extends('frontend.authentication.master')

@section('title', 'Reset Password')

@section('content')
    <form action="{{ route('password.reset') }}" method="post" class="authentication-form px-lg-5 forgot-form">
        @csrf
        <div class="authentication-form-header text-center">
            <a href="{{ route('frontend.home') }}" class="logo">
                <img src="{{ imageRecover(readconfig('site_logo')) }}" alt="{{ readconfig('site_name') }}" width="200px"
                    style="margin:0 auto;">
            </a>
            <h3 class="form-title">Sign in</h3>
            <p class="form-des">Welcome back! Sign in to access your account.</p>
        </div>
        <div class="authentication-form-content">
            <div class="row g-4">
                <div class="col-12">
                    <div class="otp-container">
                        <input type="text" maxlength="1" name="number_1" required />
                        <input type="text" maxlength="1" name="number_2" required />
                        <input type="text" maxlength="1" name="number_3" required />
                        <input type="text" maxlength="1" name="number_4" required />
                        <input type="text" maxlength="1" name="number_5" required />
                    </div>
                </div>

                <div class="col-12">
                    <div class="form-group">
                        <button type="submit" class="create-account-btn w-100">Continue</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="authentication-form-footer">
            <p>Didn’t receive the email? Click to <a href="{{ route('resend.otp') }}">resend </a></p>
            <p>Back to <a href="{{ route('login') }}">Log in </a></p>
        </div>
    </form>
@endsection
