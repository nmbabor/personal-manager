@extends('frontend.master')

@if(isset($category))
@section('title', $category->title)
    @if($category->description != '')
        @section('meta_description', $category->description)
    @endif
    @if($category->keywords != '')
        @section('meta_keywords', $category->keywords)
    @endif
@else
    @section('title', 'Blogs')
@endif

@section('content')
<section class="team_section layout_padding">
    <div class="container">
        <div class="heading_container heading_center">
            <h2>
                Our Blogs
                @if(isset($category))
                <br>
                <small> <i class="fa fa-folder"></i> {{$category->title}} </small>
                @endif
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
            <div class="col-md-12 mt-3 border-top pt-2">
                {{$blogs->links()}}
            </div>
        </div>
       
    </div>
</section>
@endsection