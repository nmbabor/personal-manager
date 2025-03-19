@extends('frontend.master')

@section('title', $data->title)
    @if($data->meta_description != '')
        @section('meta_description', $data->meta_description)
    @endif
    @if($data->meta_tags != '')
        @section('meta_keywords', $data->meta_tags)
    @endif

@section('content')
<div id="fh5co-blog-section" class="fh5co-section-gray pt-5 pb-5">
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1 heading-section animate-box">
                <h1 class="page-title">{{$data->title}}</h1>
                <div class="blog-description">
                    {!! $data->content !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection