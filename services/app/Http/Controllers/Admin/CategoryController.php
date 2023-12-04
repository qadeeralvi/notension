<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;



class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $page_title = 'Admin | Category List';
        $content = 'admin/category-management/index';
        $categories = Category::orderBy('id', 'DESC')->get();

       return view('admin/master')->with(['content'=>$content,'title'=>$page_title,'categories'=>$categories]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $page_title = 'Admin | Add Category ';
        $content = 'admin/category-management/add-category';
        $categories = Category::all();

       return view('admin/master')->with(['content'=>$content,'title'=>$page_title,'categories'=>$categories]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $file_name = '';

        if($request->hasFile('image')) {

            $file = $request->file('image');

                $name = $file->getClientOriginalName().'.'.$file->getClientOriginalExtension();

                $image['filePath'] = $name;

                $file_name = time().mt_rand(1,99999).'.'.$file->getClientOriginalExtension();;

                $file->move(public_path().'/admin_assets/category_img/', $file_name);
        }
        
        Category::updateOrCreate([
            'id'=>$request->category_id,
        ],[

            'name'=>$request->category,
            'days'=>$request->days,
            'end_time'=>$request->end_time,
            'minimum'=>$request->minimum,
            'maximum'=>$request->maximum,
            'less_assign'=>$request->less_assign,
            'last_assign'=>$request->last_assign,
            'location'=>$request->location,
            'maximum_rating'=>$request->maximum_rating,
              'image'=>$file_name,


            ]);
            return redirect()->back()->with('success','Successfully Added');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $page_title = 'Admin | Update Category';
        $content = 'admin/category-management/edit';
        $category = Category::findorfail($id);

       return view('admin/master')->with(['content'=>$content,'title'=>$page_title,'category'=>$category]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       dd(68498);
    }
}
