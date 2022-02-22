<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Brand;

class BrandsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $brands = brand::orderBy('brand')->get();
        return view('brands.index', compact('brands'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('brands.create');
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
                'brand'=>'required|unique:brands,brand'
            ],
            [
                'brand.required'=>'Brend nomini kiriting!',
                'brand.unique'=>"Ushbu brend bazada mavjud!!!"
            ]);
            if($validator ->fails()){
                return response()->json([
                    'status'=>400,
                    'errors'=>$validator->messages(),
                ]);
                
            }
            else {
                $brand = new brand;
                $brand ->brand = $request->input('brand');
                $brand->save();
    
                
                return response()->json([
                    'brand'=> $brand->brand,
                     'id'=> $brand->id
                ]);
            }
        }
        else{
            $data = $request->validate([
                'brand'=>'required|unique:brands,brand'
            ],
            [
                'brand.required'=>'Brend nomini kiriting!',
                'brand.unique'=>"Ushbu brend bazada mavjud!!!"
            ]);
            brand::create($data);
            return redirect()->back()->with('message', '"'.$request->brand . '"' .' brendi bazaga muvaffaqiyatli kiritildi!');
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
        $brand = brand::find($id);  
        return view('brands.edit',compact('brand'));
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
        $brand = brand::find($id);
        $a=strtolower($request->brand);
        $b=strtolower($brand->brand);
        if($a==$b){
            $data = $request->validate([
                'brand'=>''
            ]);
            $brand->update($data);
            return redirect()->route('brands.index');
        }
        
        $data = $request->validate([
            'brand'=>'required|unique:brands,brand'
        ],
        [
            'brand.required'=>'Brend nomini kiriting!',
            'brand.unique'=>"Ushbu brend bazada mavjud!!!"
        ]);
        $brand->update($data);
        return redirect()->route('brands.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $brand = brand::find($id);
        $brand->delete();
        return redirect()->route('brands.index');
    }
}
