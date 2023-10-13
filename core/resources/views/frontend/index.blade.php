@extends('frontend.master')

@section('title', 'Home')
@section('page', 'home')

@section('slider')
<section class=" slider_section ">
    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            @foreach($sliders as $sKey => $slider)
            <div class="carousel-item {{$sKey==0?'active':''}}">
                <div class="container">
                    <div class="row">
                        <div class="col-md-7">
                            <div class="detail-box">
                                <h1>
                                    <span> {{$slider->title}} </span>
                                </h1>
                                <p>
                                   {{$slider->description}}
                                </p>
                                @if($slider->link != '')
                                <div class="btn-box">
                                    <a href="{{$slider->link}}" class="btn-1"> Read more </a>
                                    {{-- <a href="" class="btn-2">Get A Quote</a> --}}
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            
        </div>
        <div class="container idicator_container">
            <ol class="carousel-indicators">
                @foreach($sliders as $sKey => $slider)
                <li data-target="#carouselExampleIndicators" data-slide-to="{{$sKey}}" class="{{$sKey==0?'active':''}}"></li>
                @endforeach
            </ol>
        </div>
    </div>
</section>
@endsection

@section('content')
    <!-- about section -->

<section class="about_section layout_padding">
    <div class="container">
        <div class="row">
            <div class="col-md-6 px-0">
                <div class="img_container">
                    <div class="img-box">
                        <img src="{{asset('assets/frontend/images/about-img.jpg')}}" alt=""/>
                    </div>
                </div>
            </div>
            <div class="col-md-6 px-0">
                <div class="detail-box">
                    <div class="heading_container ">
                        <h2>
                            Who Are We?
                        </h2>
                    </div>
                    <p>
                        {{readConfig('short_description')}}
                    </p>
                    <div class="btn-box">
                        <a href="{{url('pages/about-us')}}">
                            Read More
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- end about section -->

<!-- service section -->


<section class="team_section layout_padding">
    <div class="container">
        <div class="heading_container heading_center">
            <h2>
                Featured Blog
            </h2>
            <p>
                Stay up-to-date with the latest trends, news, and tips from our team of experts.
                Discover a world of knowledge, inspiration, and valuable information right here in our featured blog.
            </p>
        </div>
        <div class="row">
            @foreach($blogs as $blog)
            <div class="col-md-4 col-sm-6 mx-auto featured-blog mt-3">
                <div class="blog-box">
                    <a href="{{route('frontend.blog.show',$blog->slug)}}">
                        <div class="box">
                            <div class="img-box">
                                <img src="{{ imageRecover($blog->thumbnail) }}" alt="{{$blog->title}}">
                            </div>
                        </div>
                    </a>
                    <div class="text-box p-3">
                        <h6>
                            <a href="{{route('frontend.blog.show',$blog->slug)}}">
                                {{$blog->title}}
                            </a>
                        </h6>
                        <div class="row">
                            <div class="col-6"> <i class="fa fa-calendar"></i>  {{date('jS M, Y',strtotime($blog->created_at))}} </div>
                            <div class="col-6"> <a href="{{route('frontend.blogs.category',$blog->category->slug)}}"> <i class="fa fa-folder"></i> {{$blog->category->title??""}} </a> </div>
                        </div>
                        <p class="text-center mb-0 mt-3"> <a class="btn btn-primary" href="{{route('frontend.blog.show',$blog->slug)}}"> Read more </a> </p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="btn-box">
            <a href="{{route('frontend.blogs')}}">
                View All
            </a>
        </div>
    </div>
</section>

<!-- end team section -->
@endsection
