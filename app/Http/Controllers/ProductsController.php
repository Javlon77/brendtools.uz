<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = product::orderBy('product')->get();
        $categories = category::orderBy('category')->get();
        $brands = brand::orderBy('brand')->get();
        return view('products.index', compact('products','categories','brands'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = category::orderBy('category')->get();
        $brands = brand::orderBy('brand')->get();
        return view('products.create', compact('categories','brands'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'hasInSite'=>'',
            'category_id'=>'required',
            'brand_id'=>'required',
            'product'=>'required|unique:products,product',
        ],
        [
            'category_id.required'=>'Kategorya nomini kiriting!',
            'brand_id.required'=>'Brend nomini kiriting!',
            'product.required'=>'Mahsulot nomini kiriting!',
            'product.unique'=>"Ushbu mahsulot bazada mavjud!!!"
        ]);
        product::create($data);
        return redirect()->back()->with('message', '"'.$request->product . '"' .' nomli mahsulot bazaga muvaffaqiyatli kiritildi!');
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
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
        $product = product::find($id); 
        $categories = category::orderBy('category')->get();
        $brands = brand::orderBy('brand')->get();
        return view('products.edit', compact('categories','brands','product'));
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
        $product = product::find($id);
        $a=strtolower($request->product);
        $b=strtolower($product->product);
        
        if($a==$b){
            $data = $request->validate([
                'hasInSite'=>'',
                'category_id'=>'required',
                'brand_id'=>'required',
                'product'=>'',
            ],
            [
                'category_id.required'=>'Kategorya nomini kiriting!',
                'brand_id.required'=>'Brend nomini kiriting!',
            ]);
            $product->update($data);
            return redirect()->route('products.index');
        }

        $data = $request->validate([
            'hasInSite'=>'',
            'category_id'=>'required',
            'brand_id'=>'required',
            'product'=>'required|unique:products,product',
        ],
        [
            'category_id.required'=>'Kategorya nomini kiriting!',
            'brand_id.required'=>'Brend nomini kiriting!',
            'product.required'=>'Mahsulot nomini kiriting!',
            'product.unique'=>"Ushbu mahsulot bazada mavjud!!!"
        ]);
        $product->update($data);
        return redirect()->route('products.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = product::find($id);
        $product->delete();
        return redirect()->route('products.index');
    }
}
