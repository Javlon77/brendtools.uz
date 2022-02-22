<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function search(Request $request){   
        if($request->ajax()){ 
            $search=$request->get('search');
            $product=product::where('product','like','%' .$search . '%')->get();
            return $product;
        }
        
    }
}
