<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sales;

class CheckSaleController extends Controller
{
    // checks that the client bought any product before
    public function check(Request $request){ 
        $count = Sales::where('client_id', $request -> client_id)->count();
        return $count;
    }
}