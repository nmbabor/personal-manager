<?php

namespace App\Http\Controllers\Backend;

use App\Models\Blog;
use App\Models\Category;
use Illuminate\Support\Str;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ImageHandlerController;
use Yajra\DataTables\DataTables;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $allData = Blog::with('category')->latest();
    
            return DataTables::of($allData)
                ->addIndexColumn()
                ->addColumn('DT_RowIndex','')
                ->addColumn('category_name', function ($data) {
                    return $data->category->title ?? '';
                })
                ->editColumn('status', function ($data) {
                    if($data->status == 1){
                        return "<span class='badge bg-success'>Active</span>";
                    }else{
                        return "<span class='badge bg-danger'>inactive</span>";
                    }
                })
                ->addColumn('created', function ($data) {
                    return date('d M, Y', strtotime($data->created_at));
                })
                ->addColumn(
                    'action',
                    '<div class="action-wrapper">
                    <a class="btn btn-xs bg-gradient-primary"
                        href="{{ route(\'backend.admin.blogs.edit\', $id) }}">
                        <i class="fas fa-edit"></i>
                    </a>
                    <a class="btn btn-xs bg-gradient-danger"
                        href="#"
                        onclick="confirmDelete(\'{{ route(\'backend.admin.blogs.delete\', $id) }}\')">
                        <i class="fas fa-trash-alt"></i>
                    </a>
                    
                </div>'
                )
                ->rawColumns(['status', 'created', 'action'])
                ->toJson();
        }
        
        return view('backend.blog.index');
    }

    public function fetchBlogData(Request $request)
    {
        if ($request->ajax()) {

            $blogs = Blog::with(['category'])->latest()->paginate(10);
            return view('backend.blog.blog-table-data', compact('blogs'))->render();
        }
    }

    public function createBlog(Request $request)
    {
        $categories = BlogCategory::where('status', 1)->get(['id', 'title']);

        if ($request->isMethod('post')) {
            $request->validate([
                'title' => 'required|string',
                'slug' => 'required|unique:blogs',
                'long_description' => 'required',
                'thumbnail' => 'required|image|mimes:jpeg,png,jpg|max:2048',
                'status' => 'nullable',
                'category_id' => 'required',
                'meta_tags' => 'nullable',
                'meta_description' => 'nullable',
            ]);

            $slug = Str::slug($request->slug);
            $findSlugMatch = Blog::where('slug', $slug)->first();

            if ($findSlugMatch) {
                return back()->with('error', 'Slug already exists')->withInput();
            }

            $newBlog = new Blog();
            $newBlog->title = $request->title;
            $newBlog->slug = $slug;
            $newBlog->description = $request->long_description;
            $newBlog->status = $request->status ? 1 : 0;
            $newBlog->blog_category_id = $request->category_id;
            $newBlog->meta_tags = $request->meta_tags;
            $newBlog->meta_description = $request->meta_description;

            if ($request->hasFile("thumbnail")) {
                $newBlog->thumbnail = uploadBigImageAndGetPath($request->file("thumbnail"), "assets/images/blogs");
            }

            $newBlog->author_id = auth()->id();
            $newBlog->save();

            return redirect()->route('backend.admin.blogs')->with('success', 'Blog created successfully');
        } else {
            return view('backend.blog.create-blog', compact('categories'));
        }
    }

    public function editBlog(Request $request, $id)
    {
        $categories = BlogCategory::where('status', 1)->get(['id', 'title']);

        $blogDetails = Blog::findOrFail($id);

        // dd($blogDetails);
        if ($request->isMethod('post')) {
            $request->validate([
                'title' => 'required|string',
                'long_description' => 'required',
                'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
                'status' => 'nullable',
                'category_id' => 'required',
                'meta_tags' => 'nullable',
                'meta_description' => 'nullable',
            ]);

            $slug = Str::slug($request->title);
            $findSlugMatch = Blog::where('slug', $slug)->whereNot('id', $id)->first();

            if ($findSlugMatch) {
                return back()->with('error', 'Title already exists')->withInput();
            }

            $blogDetails->title = $request->title;
            $blogDetails->slug = $slug;
            $blogDetails->description = $request->long_description;
            $blogDetails->status = $request->status ? 1 : 0;
            $blogDetails->blog_category_id = $request->category_id;
            $blogDetails->meta_tags = $request->meta_tags;
            $blogDetails->meta_description = $request->meta_description;

            if ($request->hasFile("thumbnail")) {

                secureUnlink($blogDetails->thumbnail);

                $blogDetails->thumbnail = uploadBigImageAndGetPath($request->file("thumbnail"), "assets/images/blogs");
            }

            $blogDetails->save();

            return redirect()->route('backend.admin.blogs')->with('success', 'Blog updated successfully');
        } else {
            return view('backend.blog.edit-blog', compact('categories', 'blogDetails'));
        }
    }

    public function deleteBlog($id)
    {
        try {
            $blog = Blog::findOrFail($id);
            $link = $blog->thumbnail;

            $blog->delete();

            secureUnlink($link);

            return back()->with('success', 'Blog deleted successfully');
        } catch (\Exception $e) {
            return back()->with('error', 'Unable to delete the selected item: It is associated with other data and cannot be removed');
        }
    }
}
