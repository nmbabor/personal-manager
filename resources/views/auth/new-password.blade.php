@extends('auth.master')

@section('title', 'Reset Password')

@section('content')
    <form action="{{ route('new.password') }}" method="post" class="authentication-form px-lg-5"
        id="resetPasswordForm needs-validation" novalidate>
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
                <div class="col-xl-8">
                    <div class="form-group">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" placeholder="Enter password"
                            autocomplete="off" name="password" required>
                        <div class="invalid-feedback" id="passwordValidationText">Enter password</div>
                        <div class="show-hide toggle-password" id="toggleIcon">

                            <span class="eye-icon">
                                <svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M0.75 9C0.75 9 3.75 3 9 3C14.25 3 17.25 9 17.25 9C17.25 9 14.25 15 9 15C3.75 15 0.75 9 0.75 9Z"
                                        stroke="#E2E8F0" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                    </path>
                                    <path
                                        d="M9 11.25C10.2426 11.25 11.25 10.2426 11.25 9C11.25 7.75736 10.2426 6.75 9 6.75C7.75736 6.75 6.75 7.75736 6.75 9C6.75 10.2426 7.75736 11.25 9 11.25Z"
                                        stroke="#E2E8F0" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                    </path>
                                </svg>

                            </span>
                            <span class="eye-off d-none">
                                <svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_157_8998)">
                                        <path
                                            d="M13.455 13.455C12.1729 14.4323 10.6118 14.9737 9 15C3.75 15 0.75 9.00002 0.75 9.00002C1.68292 7.26144 2.97685 5.74247 4.545 4.54502M7.425 3.18002C7.94125 3.05918 8.4698 2.99877 9 3.00002C14.25 3.00002 17.25 9.00002 17.25 9.00002C16.7947 9.85172 16.2518 10.6536 15.63 11.3925M10.59 10.59C10.384 10.8111 10.1356 10.9884 9.85962 11.1114C9.58362 11.2343 9.28568 11.3005 8.98357 11.3058C8.68146 11.3111 8.38137 11.2555 8.10121 11.1424C7.82104 11.0292 7.56654 10.8608 7.35289 10.6471C7.13923 10.4335 6.9708 10.179 6.85763 9.89881C6.74447 9.61865 6.6889 9.31856 6.69423 9.01645C6.69956 8.71434 6.76568 8.4164 6.88866 8.1404C7.01163 7.86441 7.18894 7.616 7.41 7.41002"
                                            stroke="#E2E8F0" stroke-width="1.5" stroke-linecap="round"
                                            stroke-linejoin="round"></path>
                                        <path d="M0.75 0.75L17.25 17.25" stroke="#E2E8F0" stroke-width="1.5"
                                            stroke-linecap="round" stroke-linejoin="round"></path>
                                    </g>
                                    <defs>
                                        <clipPath id="clip0_157_8998">
                                            <rect width="18" height="18" fill="white"></rect>
                                        </clipPath>
                                    </defs>
                                </svg>

                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-xl-8">
                    <div class="form-group">
                        <label for="confirmPassword" class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" id="confirmPassword" placeholder="Confirm password"
                            autocomplete="off" name="password_confirmation" required>
                        <div class="invalid-feedback" id="confirmPasswordValidationText"></div>
                        <div class="show-hide toggle-password" id="toggleIcon">

                            <span class="eye-icon">
                                <svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M0.75 9C0.75 9 3.75 3 9 3C14.25 3 17.25 9 17.25 9C17.25 9 14.25 15 9 15C3.75 15 0.75 9 0.75 9Z"
                                        stroke="#E2E8F0" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                    </path>
                                    <path
                                        d="M9 11.25C10.2426 11.25 11.25 10.2426 11.25 9C11.25 7.75736 10.2426 6.75 9 6.75C7.75736 6.75 6.75 7.75736 6.75 9C6.75 10.2426 7.75736 11.25 9 11.25Z"
                                        stroke="#E2E8F0" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                    </path>
                                </svg>

                            </span>
                            <span class="eye-off d-none">
                                <svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_157_8998)">
                                        <path
                                            d="M13.455 13.455C12.1729 14.4323 10.6118 14.9737 9 15C3.75 15 0.75 9.00002 0.75 9.00002C1.68292 7.26144 2.97685 5.74247 4.545 4.54502M7.425 3.18002C7.94125 3.05918 8.4698 2.99877 9 3.00002C14.25 3.00002 17.25 9.00002 17.25 9.00002C16.7947 9.85172 16.2518 10.6536 15.63 11.3925M10.59 10.59C10.384 10.8111 10.1356 10.9884 9.85962 11.1114C9.58362 11.2343 9.28568 11.3005 8.98357 11.3058C8.68146 11.3111 8.38137 11.2555 8.10121 11.1424C7.82104 11.0292 7.56654 10.8608 7.35289 10.6471C7.13923 10.4335 6.9708 10.179 6.85763 9.89881C6.74447 9.61865 6.6889 9.31856 6.69423 9.01645C6.69956 8.71434 6.76568 8.4164 6.88866 8.1404C7.01163 7.86441 7.18894 7.616 7.41 7.41002"
                                            stroke="#E2E8F0" stroke-width="1.5" stroke-linecap="round"
                                            stroke-linejoin="round"></path>
                                        <path d="M0.75 0.75L17.25 17.25" stroke="#E2E8F0" stroke-width="1.5"
                                            stroke-linecap="round" stroke-linejoin="round"></path>
                                    </g>
                                    <defs>
                                        <clipPath id="clip0_157_8998">
                                            <rect width="18" height="18" fill="white"></rect>
                                        </clipPath>
                                    </defs>
                                </svg>

                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-xl-8">
                    <div class="form-group">
                        <button type="submit" class="create-account-btn w-100" onclick="validateForm()">
                            Reset Password
                        </button>
                    </div>
                </div>
                <div class="col-xl-8">
                    <div class="authentication-form-footer">
                        <p>Back to <a href="{{ route('login') }}">Log in</a></p>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
