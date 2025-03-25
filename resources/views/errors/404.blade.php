@extends('auth.master')

@section('title', 'পেইজটি পাওয়া যায় নি।')

@section('content')
<div id="fh5co-contact" class="fh5co-section-gray">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center animate-box">
                <h2>পেইজটি পাওয়া যায় নি।</h2>
                <h5>আপনি যে পেইজটি খুঁজছেন তা এখানে নেই। দয়া করে URL টি আবার চেক করুন অথবা আমাদের হোমপেজে ফিরে যান।</h5>
                <p><a class="btn btn-primary btn-lg" href="{{url('/')}}">হোমপেজে ফিরে যান</a></p>
                <img class="img-responsive" src="{{asset('assets/images/404-error.png')}}" alt="404" style="margin:0 auto;">
            </div>
        </div>
    </div>
</div>
@endsection