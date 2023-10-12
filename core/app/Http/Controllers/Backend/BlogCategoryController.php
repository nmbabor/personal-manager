<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BlogCategoryController extends Controller
{
    public function index()
    {
        $allData = BlogCategory::get();
        return view('backend.blog.category', compact('allData'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'slug' => 'required',
        ]);
        try{
            $input = $request->except('_token');
            $input['slug'] = Str::slug($request->slug);
            BlogCategory::create($input);
            return back()->with('success', 'Data created successfully');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
        
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'slug' => 'required',
        ]);

        try {
            $data = BlogCategory::findOrFail($id);
            $input = $request->except(['_token', '_method']);
            $input['slug'] = Str::slug($request->slug);
            
            $data->update($input);
            return back()->with('success', 'Data updated successfully');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $data = BlogCategory::findOrFail($id);
            $data->delete();
            return back()->with('success', 'Data deleted successfully');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
