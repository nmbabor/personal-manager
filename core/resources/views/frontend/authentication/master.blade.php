<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        @yield('title') | {{ readConfig('site_name') }}
    </title>
    <!-- FAVICON ICON -->
    <link rel="shortcut icon" href="{{ imageRecover(readconfig('favicon_icon')) }}" type="image/svg+xml">
    <!-- BACK-TOP CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/back-top/backToTop.css') }}">
    <!-- BOOTSTRAP CSS (5.3) -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap/bootstrap.min.css') }}">
    <!-- APP-CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.min.css') }}">
    @stack('style')
</head>

<body>
    <x-simple-alert />

    <!-- AUTHENTICATION-START (LOGIN) -->
    <section class="authentications">
        <div class="left-content">
            <div class="text-center">
                <h1> Welcome to <b>{{readConfig('site_name')}}</b> </h1>
                <h4>{{readConfig('sub_title')}}</h4>
                <img class="img-responsive" src="{{ asset('assets/images/dupkt-logo.png') }}" alt="Authentication">
            </div>
        </div>
        <div class="right-content">
            @yield('content')
        </div>
    </section>
    <!-- AUTHENTICATION-END -->


    <!-- BOOTSTRAP JS (5.3) -->
    <script src="{{ asset('assets/js/bootstrap/bootstrap.bundle.min.js') }}"></script>
    <!-- BOOTSTRAP-TOOLTIP -->
    <script src="{{ asset('assets/js/tooltip/tooltip.js') }}"></script>
    <!-- BACK-TOP JS -->
    <script src="{{ asset('assets/js/back-top/backToTop.js') }}"></script>
    <script src="{{ asset('assets/js/back-top/backtop.js') }}"></script>
    <!-- COPYRIGHT JS -->
    <script src="{{ asset('assets/js/copyright/copyright.js') }}"></script>
    <script src="{{ asset('assets/js/validation/validation.js') }}"></script>
    <script>
        // Get all password input elements and toggle icons
        const passwordInputs = document.querySelectorAll('.form-control[type="password"]');
        const toggleIcons = document.querySelectorAll('.toggle-password');

        // Add click event listeners to toggle icons
        toggleIcons.forEach((toggleIcon, index) => {
            toggleIcon.addEventListener('click', () => {
                // Toggle the visibility of the respective password field
                if (passwordInputs[index].type === 'password') {
                    passwordInputs[index].type = 'text';
                    toggleIcon.querySelector('.eye-icon').classList.add('d-none');
                    toggleIcon.querySelector('.eye-off').classList.remove('d-none');
                } else {
                    passwordInputs[index].type = 'password';
                    toggleIcon.querySelector('.eye-icon').classList.remove('d-none');
                    toggleIcon.querySelector('.eye-off').classList.add('d-none');
                }
            });
        });
    </script>
    @stack('scripts')
</body>

</html>
