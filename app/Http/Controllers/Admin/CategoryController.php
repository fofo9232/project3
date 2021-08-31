<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $category=Category::orderBy('id','DESC')->paginate(10);
        return view('backend.category.index')->with('categories',$category);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $parent_cats=Category::where('is_parent',1)->orderBy('title','ASC')->get();
        return view('backend.category.create')->with('parent_cats',$parent_cats);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request->all();
        $this->validate($request,[
            'title'=>'string|required',
            'summary'=>'string|nullable',
            //'photo'=>'string|nullable',
            'status'=>'required|in:active,inactive',
            'is_parent'=>'sometimes|in:1',
            'parent_id'=>'nullable|exists:categories,id',
        ]);
        $data= $request->all();
        $slug=Str::slug($request->title);
        $count=Category::where('slug',$slug)->count();
        if($count>0){
            $slug=$slug.'-'.date('ymdis').'-'.rand(0,999);
        }
        $filePath = "";
            if ($request->has('photo')) {

                $filePath = uploadImage('category', $request->photo);
            }
        $data['slug']=$slug;
        $data['is_parent']=$request->input('is_parent',0);
        $data['photo']=$filePath;
        // return $data;   
        $status=Category::create($data);
        if($status){
            request()->session()->flash('success','Category successfully added');
        }
        else{
            request()->session()->flash('error','Error occurred, Please try again!');
        }
        return redirect()->route('category.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $parent_cats=Category::where('is_parent',1)->get();
        $category=Category::findOrFail($id);
        return view('backend.category.edit')->with('category',$category)->with('parent_cats',$parent_cats);
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
       // return $request->all();
       $category=Category::findOrFail($id);
       $this->validate($request,[
           'title'=>'string|required',
           'summary'=>'string|nullable',
           //'photo'=>'string|nullable',
           'status'=>'required|in:active,inactive',
           'is_parent'=>'sometimes|in:1',
           'parent_id'=>'nullable|exists:categories,id',
       ]);
       
       try {
        
        
        
        if ($request->has('photo')) {
            $filePath = uploadImage('category', $request->photo);
            Category::where('id', $id)
                ->update([
                    'photo' => $filePath,
                ]);}

                $category->update($request->except('_token','photo'));

        return redirect()->route('category.index')->with(['success' => 'تم تحديث اللغة بنجاح']);

    } catch (\Exception $ex) {
        return redirect()->route('category.index')->with(['error' => 'هناك خطا ما يرجي المحاوله فيما بعد']);
    } 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category=Category::findOrFail($id);
        $child_cat_id=Category::where('parent_id',$id)->pluck('id');
        // return $child_cat_id;
        $status=$category->delete();
        
        if($status){
            if(count($child_cat_id)>0){
                Category::shiftChild($child_cat_id);
            }
            request()->session()->flash('success','Category successfully deleted');
        }
        else{
            request()->session()->flash('error','Error while deleting category');
        }
        return redirect()->route('category.index');
    }
}
