<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use App\Models\Page;
use App\Models\SubMenu;
use Illuminate\Http\Request;

class SubMenuController extends Controller
{

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        try{
            $input = [
                'name' => $request->name, 
                'url' => $request->url,
                'serial_num' => $request->serial_num,
                'menu_id'=>$request->menu_id,
            ];
            if($request->type==1){
                if($request->name == ''){
                    return redirect()->back()->with('error','Name can not be null.');
                }
                if($request->url == ''){
                    return redirect()->back()->with('error','Menu URL can not be null.');
                }
            }elseif($request->type==2){
                $page = Page::findOrFail($request->page_id);
                $input['name'] = $page->title;
                $input['url'] = 'pages/'.$page->slug;
    
            }else if($request->type==3){
                $category = BlogCategory::findOrFail($request->category_id);
                $input['name'] = $category->title;
                $input['url'] = 'blogs/'.$category->slug;
            }
            
            SubMenu::create($input);
            return back()->with('success', 'Sub Menu created successfully');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name'=>'required',
            'url'=>'required',
        ]);

        try {
            $data = SubMenu::findOrFail($id);
            $input = $request->except(['_token', '_method']);
            
            $data->update($input);
            return back()->with('success', 'Sub Menu updated successfully');
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
            $data = SubMenu::findOrFail($id);
            $data->delete();
            return back()->with('success', 'Sub Menu deleted successfully');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
