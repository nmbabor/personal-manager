<!DOCTYPE html>
<html>

<head>
    <!-- Basic -->
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <!-- Mobile Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    <!-- Site Metas -->
	<meta name="description" content="@yield('meta_description',readConfig('meta_description'))" />
	<meta name="keywords" content="@yield('meta_keywords',readConfig('meta_keywords'))" />
	<meta name="author" content="{{ readConfig('site_name') }}" />
	<meta property="og:title" content="@yield('title', readConfig('site_name'))"/>
	<meta property="og:image" content="@yield('og_image',imageRecover(readconfig('site_logo')))"/>
	<meta property="og:url" content="{{ request()->fullUrl() }}"/>
	<meta property="og:site_name" content="{{ readConfig('site_name') }}"/>
	<meta property="og:description" content="@yield('meta_description',readConfig('meta_description'))"/>
	<meta name="twitter:title" content="@yield('title', readConfig('site_name'))" />
	<meta name="twitter:image" content="@yield('og_image',imageRecover(readconfig('site_logo')))" />
	<meta name="twitter:url" content="{{ request()->fullUrl() }}" />

	<!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
    <link rel="shortcut icon" href="{{ imageRecover(readconfig('favicon_icon')) }}" type="image/x-icon">

    <title> @yield('title') | {{ readConfig('site_name') }}</title>

    <!-- bootstrap core css -->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/frontend/css/bootstrap.css')}}"/>

    <!-- fonts style -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700|Poppins:400,600,700&display=swap"
          rel="stylesheet"/>

    <!-- Custom styles for this template -->
    <link href="{{asset('assets/frontend/css/style.css')}}" rel="stylesheet"/>
    <!-- responsive style -->
    <link href="{{asset('assets/frontend/css/responsive.css')}}" rel="stylesheet"/>
    <link href="{{asset('assets/frontend/css/custom.css')}}" rel="stylesheet"/>
	@stack('style')
</head>

<body class="@yield('page','sub_page')">
<div class="hero_area">
    <!-- header section strats -->
    <div class="hero_bg_box">
        <div class="img-box">
            <img src="{{asset('assets/frontend/images/hero-bg.jpg')}}" alt="">
        </div>
    </div>

    <header class="header_section">
        <div class="header_top">
            <div class="container-fluid">
                <div class="contact_link-container">
                    <a href="" class="contact_link1">
                        <i class="fa fa-map-marker" aria-hidden="true"></i>
							<span> {{readconfig('contact_address')}}  </span>
                    </a>
                    <a href="" class="contact_link2">
                        <i class="fa fa-phone" aria-hidden="true"></i>
                        <span> Call : {{readconfig('contact_mobile')}} </span>
                    </a>
                    <a href="" class="contact_link3">
                        <i class="fa fa-envelope" aria-hidden="true"></i>
                        <span> {{readconfig('contact_email')}} </span>
                    </a>
                </div>
            </div>
        </div>
        <div class="header_bottom">
            <div class="container-fluid">
                <nav class="navbar navbar-expand-lg custom_nav-container">
                    <a class="navbar-brand" href="{{url('/')}}">
              <span>
                <img src="{{ imageRecover(readconfig('site_logo')) }}" alt="{{readconfig('site_name')}}" style="max-width:220px">
              </span>
                    </a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse"
                            data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                            aria-expanded="false" aria-label="Toggle navigation">
                        <span class=""></span>
                    </button>

                    <div class="collapse navbar-collapse ml-auto" id="navbarSupportedContent">
                        <ul class="navbar-nav  ">
							@foreach(menus() as $menu)
                            <li class="nav-item {{request()->path() == $menu->url ? 'active' : ''}}">
                                @if(count($menu->subMenus)>0)
                                <a class="nav-link" href="{{url($menu->url)}}">{{$menu->name}} <i class="fa fa-caret-down"></i> </a>
								<ul class="sub-menu">
									@foreach($menu->subMenus->sortBy('serial_num') as $subMenu)
									<li><a href="{{url($subMenu->url)}}">{{$subMenu->name}}</a></li>
									@endforeach
								</ul>
                                @else
                                <a class="nav-link" href="{{url($menu->url)}}">{{$menu->name}} </a>
								@endif
                            </li>
							@endforeach
                            @if(Auth::check())
                            <li class="nav-item">
                                <a class="nav-link" href="{{route('dashboard.redirect')}}">Dashboard</a>
                            </li>
                            @else
                            <li class="nav-item">
                                <a class="nav-link" href="{{route('login')}}">Login</a>
                            </li>
                            {{-- <li><a href="{{route('signup')}}">Signup</a></li> --}}
                            @endif
                            
                        </ul>
                    </div>
                </nav>
            </div>
        </div>
    </header>
    <!-- end header section -->
	@yield('slider')
</div>

@yield('content')

<!-- info section -->
<section class="info_section ">
    <div class="container">
        <div class="row">
			<div class="col-md-4">
                <div class="info_info">
                    <h5>
                        Contact Us
                    </h5>
                </div>
                <div class="info_contact">
                    <p class="">
                        <i class="fa fa-map-marker" aria-hidden="true"></i>
                        <span>{{readconfig('contact_address')}}</span>
					</p>
                    <a href="tel:{{readconfig('contact_mobile')}}" class="">
                        <i class="fa fa-phone" aria-hidden="true"></i>
                        <span>
                Call : {{readconfig('contact_mobile')}}
              </span>
                    </a>
                    <a href="mailto:{{readconfig('contact_email')}}" class="">
                        <i class="fa fa-envelope" aria-hidden="true"></i>
                        <span> {{readconfig('contact_email')}} </span>
                    </a>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="info_links">
                    <h5>
                        Quick Link
                    </h5>
                    <ul>
						<li class="my-1"><a href="{{url('/pages/terms-condition')}}">Terms of condition</a></li>
						<li class="my-1"><a href="{{url('/pages/privacy-policy')}}">Privacy Policy</a></li>
						<li class="my-1"><a href="{{url('/pages/refund-policy')}}">Refund Policy</a></li>
						@if(Auth::check())
						<li class="my-1"><a href="{{route('dashboard.redirect')}}">Dashboard</a></li>
						@else
						<li class="my-1"><a href="{{route('login')}}">Login</a></li>
						{{-- <li><a href="{{route('signup')}}">Signup</a></li> --}}
						@endif
					</ul>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="info_form ">
					
                    <h5> Connect with us </h5>
					<p>Follow us on social media and join our online community for a journey of discovery.</p>
                    <div class="social_box">
						@if(readconfig('facebook_link') != null)
							<a title="Facebook" href="{{readconfig('facebook_link')}}" target="_blank"><i class="fa fa-facebook"></i></a>
						@endif
						@if(readconfig('twitter_link') != null)
							<a title="Twitter" href="{{readconfig('twitter_link')}}" target="_blank"><i class="fa fa-twitter"></i></a>
						@endif
						@if(readconfig('linkedin_link') != null)
							<a title="Linkedin" href="{{readconfig('linkedin_link')}}" target="_blank"><i class="fa fa-twitter"></i></a>
						@endif
						@if(readconfig('youtube_link') != null)
						<a title="Youtube" href="{{readconfig('youtube_link')}}" target="_blank"><i class="fa fa-youtube"></i></a>
						@endif
						@if(readconfig('instagram_link') != null)
						<a title="Instagram" href="{{readconfig('instagram_link')}}" target="_blank"><i class="fa fa-instagram"></i></a>
						@endif
						@if(readconfig('pinterest_link') != null)
						<a title="Pinterest" href="{{readconfig('pinterest_link')}}" target="_blank"><i class="fa fa-pinterest"></i></a>
						@endif 

						@if(readconfig('tumblr_link') != null)
						<a title="Tumblr" href="{{readconfig('tumblr_link')}}" target="_blank"><i class="fa fa-tumblr"></i></a>
						@endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- end info_section -->


<!-- footer section -->
<footer class="container-fluid footer_section">
    <p>
        &copy; <span id="currentYear"></span> <a href="{{readconfig('site_url')}}"> {{readconfig('site_name')}} </a>. All Rights Reserved.
    </p>
</footer>
<!-- footer section -->

<script src="{{asset('assets/frontend/js/jquery-3.4.1.min.js')}}"></script>
<script src="{{asset('assets/frontend/js/bootstrap.js')}}"></script>
<script src="{{asset('assets/frontend/js/custom.js')}}"></script>
</body>

</html>

	