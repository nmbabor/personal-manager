<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\Page;
use App\Models\PricingPlan;
use App\Models\TextSlider;


class HomeController extends Controller
{
    public function index(){
        $blogs = Blog::whereStatus(1)->latest()->take(3)->get();
        $sliders = TextSlider::whereStatus(1)->latest()->get();
        return view('frontend.index',compact('blogs','sliders'));
    }
    public function blogs(){
        $blogs = Blog::whereStatus(1)->latest()->paginate(12);
        return view('frontend.blog.index',compact('blogs'));
    }
    
    public function blogCategory($slug){
        $category = BlogCategory::where('slug',$slug)->firstOrFail();
        $blogs = Blog::whereStatus(1)->latest()->where('blog_category_id',$category->id)->paginate(12);
        return view('frontend.blog.index',compact('blogs','category'));
    }
    public function singleBlog($slug){
        $data = Blog::whereStatus(1)->where('slug',$slug)->firstOrFail();
        $categories = BlogCategory::whereStatus(1)->get();
        return view('frontend.blog.single',compact('data','categories'));
    }
    public function singlePage($slug){
        $data = Page::whereStatus(1)->where('slug',$slug)->firstOrFail();
        return view('frontend.singlePage',compact('data'));
    }

    
}
