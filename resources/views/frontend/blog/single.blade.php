@extends('frontend.master')

@section('title', $data->title)
    @if($data->meta_description != '')
        @section('meta_description', $data->meta_description)
    @endif
    @if($data->meta_tags != '')
        @section('meta_keywords', $data->meta_tags)
    @endif
    @if($data->thumbnail != '')
        @section('og_image', imageRecover($data->thumbnail))
    @endif

@section('content')
<section class="team_section single-blog">
    <div class="container">
        <div class="heading_container heading_center py-5">
            <h2>
                Our Blog
            </h2>
        </div>
        <div class="row">
            <div class="col-md-8 heading-section animate-box">
                <div class="blog-image">
                    <img class="img-responsive" src="{{imageRecover($data->thumbnail)}}" alt="{{$data->title}}">
                </div>
                <h1 class="blog-title">{{$data->title}}</h1>
                <div class="blog-tag">
                    <span class="posted_by"> <i class="fa fa-calendar"></i> {{date('jS M, Y',strtotime($data->created_at))}} </span>
                    <span class="comment pl-2"> <a href="{{route('frontend.blogs.category',$data->category->slug)}}"> <i class="fa fa-folder"></i> {{$data->category->title??""}} </a></span>
                </div>
                <div class="blog-description">
                    {!! $data->description !!}
                </div>
            </div>
            <div class="col-md-4 ">
                <div class="category-box">
                    <h3 class="title"> Categories </h3>
                    <ul class="">
                        @foreach($categories as $cat)
                        <li class=""><a href="{{route('frontend.blogs.category',$cat->slug)}}"> <i class="fa fa-folder"></i> {{$cat->title}} </a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection