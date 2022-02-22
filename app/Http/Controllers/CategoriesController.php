<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Category;
class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = category::orderBy('category')->get();
        return view('categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->ajax()){
            $validator =Validator::make($request->all(),[
                'category'=>'required|unique:categories,category'
            ],
            [
                'category.required'=>'Kategorya nomini kiriting!',
                'category.unique'=>"Ushbu kategorya bazada mavjud!!!"
            ]);
            if($validator ->fails()){
                return response()->json([
                    'status'=>400,
                    'errors'=>$validator->messages(),
                ]);    
            }
            else {
                $category = new category;
                $category ->category = $request->input('category');
                $category->save();     
                return response()->json([
                    'category'=> $category ->category,
                     'id'=> $category ->id
                ]);
            }
        }
        else{
            $data = $request->validate([
                'category'=>'required|unique:categories,category'
            ],
            [
                'category.required'=>'Kategorya nomini kiriting!',
                'category.unique'=>"Ushbu kategorya bazada mavjud!!!"
            ]);
            category::create($data);
            return redirect()->back()->with('message', '"'.$request->category . '"' .' kategoryasi bazaga muvaffaqiyatli kiritildi!');
        }
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
        $category = category::find($id);  
        return view('categories.edit',compact('category'));
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
        $category = category::find($id);
        $a=strtolower($request->category);
        $b=strtolower($category->category);
        if($a==$b){
            $data = $request->validate([
                'category'=>''
            ]);
            $category->update($data);
            return redirect()->route('categories.index');
        }
        
        $data = $request->validate([
            'category'=>'required|unique:categories,category'
        ],
        [
            'category.required'=>'Kategorya nomini kiriting!',
            'category.unique'=>"Ushbu kategorya bazada mavjud!!!"
        ]);
        $category->update($data);
        return redirect()->route('categories.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = category::find($id);
        $category->delete();
        return redirect()->route('categories.index');
    }
}
