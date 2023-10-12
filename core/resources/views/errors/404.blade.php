@extends('frontend.master')

@section('title', 'Page not found')

@section('content')
<div id="fh5co-contact" class="fh5co-section-gray">
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2 text-center animate-box">
                <h1>Page not found</h1>
                <h4>The page you're seeking doesn't exist here. Double-check the URL or head back to our homepage to find your way.</h4>
                <p><a class="btn btn-primary btn-lg" href="{{url('/')}}">Back to Home</a></p>
                <img class="img-responsive" src="{{asset('assets/images/404-error.png')}}" alt="404" style="margin:0 auto;">
            </div>
        </div>
    </div>
</div>
@endsection