<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title','Dashboard') | {{ readConfig('site_name') }}</title>

    <!-- FAVICON ICON -->
    <link rel="shortcut icon" href="{{ imageRecover(readconfig('favicon_icon')) }}" type="image/svg+xml">

    <!-- FAVICON ICON APPLE -->
    <link href="{{ imageRecover(readconfig('favicon_icon')) }}" rel="apple-touch-icon">
    <link href="{{ imageRecover(readconfig('favicon_icon')) }}" rel="apple-touch-icon" sizes="72x72">
    <link href="{{ imageRecover(readconfig('favicon_icon')) }}" rel="apple-touch-icon" sizes="114x114">
    <link href="{{ imageRecover(readconfig('favicon_icon')) }}" rel="apple-touch-icon" sizes="144x144">

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('assets/backend/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet"
        href="{{ asset('assets/backend/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{ asset('assets/backend/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- JQVMap -->
    <link rel="stylesheet" href="{{ asset('assets/backend/plugins/jqvmap/jqvmap.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('assets/backend/dist/css/adminlte.min.css') }}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ asset('assets/backend/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{ asset('assets/backend/plugins/daterangepicker/daterangepicker.css') }}">
    <!-- summernote -->
    <link rel="stylesheet" href="{{ asset('assets/backend/plugins/summernote/summernote-bs4.min.css') }}">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('assets/backend/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/backend/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <!-- dropzonejs -->
    <link rel="stylesheet" href="{{ asset('assets/backend/plugins/dropzone/min/dropzone.min.css') }}">
    {{-- datatable --}}
    <link rel="stylesheet" href="{{ asset('assets/backend/dist/css/datatable/datatable.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/backend/dist/css/datatable/buttons.dataTables.min.css') }}">
    {{-- custom style --}}
    <link rel="stylesheet" href="{{ asset('assets/backend/dist/css/custom-style.css') }}">

    @stack('style')

</head>

<body class="hold-transition sidebar-mini layout-fixed">

    <x-simple-alert />

    <div class="wrapper">

        <!-- Preloader -->
        {{-- <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="{{ asset('assets/images/logo/logo-icon.png') }}" alt="Logo"
                height="60" width="60">
        </div> --}}

        <!-- Navbar -->
        @include('backend.layouts.navbar')
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar elevation-4 sidebar-light-primary">
            <!-- Brand Logo -->
            <a href="{{ route('frontend.home') }}" class="brand-link">
                <img src="{{ imageRecover(readconfig('site_logo')) }}" alt="Logo"
                    class="brand-image float-none">
            </a>

            <!-- Sidebar -->
            @include('backend.layouts.sidebar')
            <!-- /.sidebar -->

        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">
                                @yield('title')
                            </h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <div class="float-sm-right">
                                @yield('title_button')
                            </div>
                        </div>
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->


            <!-- Main content -->
            <section class="content">
                <!-- container-fluid -->
                <div class="container-fluid">

                    <!-- content -->
                    @yield('content')
                    <!-- /.content -->

                </div>
                <!-- /.container-fluid -->
            </section>
            <!-- /.Main content -->
        </div>
        <!-- /.content-wrapper -->

        @include('backend.layouts.footer')
        <div class="modal fade" id="resourceDelete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-body text-center">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    <h1 class="text-danger mt-4">
                       <i class="fa fa-times-circle"></i>
                    </h1>

                    <div class="delete-info">
                        <h3 class="delete-title"> Delete</h3>
                        <p class="delete-text">Are you sure you want to delete it? This action cannot be undone.
                        </p>
                    </div>
                    <div class="row justify-content-around border-top pt-3">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <a href="#" class="btn btn-success normal-delete-button" style="display: none"> <i class="fa fa-trash"></i> Confirm</a>
                        {!! Form::open(['method' => 'delete', 'class' => 'resource-delete-form']) !!}
                        <button type="submit" class="btn btn-success "> <i class="fa fa-trash"></i>
                            Confirm</button>
                        {!! Form::close() !!}
                    </div>
                </div>
              </div>
            </div>
          </div>

    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="{{ asset('assets/backend/plugins/jquery/jquery.min.js') }}"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="{{ asset('assets/backend/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('assets/backend/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- ChartJS -->
    <script src="{{ asset('assets/backend/plugins/chart.js/Chart.min.js') }}"></script>
    <!-- Sparkline -->
    <script src="{{ asset('assets/backend/plugins/sparklines/sparkline.js') }}"></script>
    <!-- JQVMap -->
    <script src="{{ asset('assets/backend/plugins/jqvmap/jquery.vmap.min.js') }}"></script>
    <script src="{{ asset('assets/backend/plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script>
    <!-- jQuery Knob Chart -->
    <script src="{{ asset('assets/backend/plugins/jquery-knob/jquery.knob.min.js') }}"></script>
    <!-- daterangepicker -->
    <script src="{{ asset('assets/backend/plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('assets/backend/plugins/daterangepicker/daterangepicker.js') }}"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="{{ asset('assets/backend/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
    <!-- Summernote -->
    <script src="{{ asset('assets/backend/plugins/summernote/summernote-bs4.min.js') }}"></script>
    <!-- overlayScrollbars -->
    <script src="{{ asset('assets/backend/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('assets/backend/dist/js/adminlte.js') }}"></script>
    <!-- Select2 -->
    <script src="{{ asset('assets/backend/plugins/select2/js/select2.full.min.js') }}"></script>
    {{-- custom script --}}
    <script src="{{ asset('assets/backend/js/custom-script.js') }}"></script>
    <!-- dropzonejs -->
    <script src="{{ asset('assets/backend/plugins/dropzone/min/dropzone.min.js') }}"></script>

    {{-- datatable --}}
    <script src="{{ asset('assets/backend/dist/js/datatable/datatable.js') }}"></script>
    <script src="{{ asset('assets/backend/dist/js/datatable/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/backend/dist/js/datatable/dataTables.buttons.min.js') }}"></script>
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-14PMPDZXRQ"></script>
    <script>
        // Get the CSRF token from the meta tag
        var csrfToken = "{{ csrf_token() }}";
        // Set up default AJAX settings
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': csrfToken // Set the CSRF token as a default header
            }
        });
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'G-14PMPDZXRQ');
    </script>
    <script type="text/javascript">
    $('.singleDatePicker').daterangepicker({
        singleDatePicker: true,
        showDropdowns: true,
        autoApply: true,
        autoUpdateInput: false,
        locale: {
            format: 'DD-MM-YYYY',
        }
    })

    $('.singleDatePicker').on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('DD-MM-YYYY'));
    });
        function resourceDelete(delete_url) {
            "use strict"
            jQuery('#resourceDelete').modal('show', {
                backdrop: 'static'
            });
            $('#resourceDelete form').attr('action', delete_url);
        }
        function confirmDelete(delete_url) {
            "use strict"
            jQuery('#resourceDelete').modal('show', {
                backdrop: 'static'
            });
            $('#resourceDelete form').hide();
            $('#resourceDelete .normal-delete-button').show();
            $('#resourceDelete .normal-delete-button').attr('href', delete_url);
        }

        function photoLoad(input,id) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#'+id).attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>



    @stack('script')

</body>

</html>
