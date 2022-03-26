<?php

namespace App\Http\Controllers;

use App\Models\Cost;
use App\Models\Currency;
use App\Models\CostCategory;
use Illuminate\Http\Request;

class CostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $costs = cost::all();
        $categories = costCategory::all();
        return view('costs.index', compact('costs', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = CostCategory::all();
        return view('costs.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    { 

        $data = $request -> validate([
            'reason' => '', 
            'category_id' => '',
            'additional' => '',
            'cost' => ''
        ]);
        $data['cost'] = str_replace(' ', '', $data['cost']);
        $data['currency'] = currency::latest()->first()->currency;
        $data['cost_usd'] = $data['cost'] / $data['currency'];
        $data['created_at'] = $request->created_at;
        $data['updated_at'] = $request->created_at;
        
        $cost = cost::create($data);
        
        return redirect() -> back() -> with('message', 'Xarajat bazaga muvafaqqiyatli kiritildi!');
        

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Cost  $cost
     * @return \Illuminate\Http\Response
     */
    public function show(Cost $cost)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Cost  $cost
     * @return \Illuminate\Http\Response
     */
    public function edit(Cost $cost)
    {
        $categories = costCategory::all();
        return view('costs.edit', compact('cost', 'categories'));
    
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cost  $cost
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cost $cost)
    {
        $data = $request -> validate([
            'reason' => '',
            'category_id' => '',
            'additional' => '', 
            'cost' => ''
        ]);
        $data['cost'] = str_replace(' ', '', $data['cost']);
        $data['currency'] = $cost -> currency;
        $data['cost_usd'] = $data['cost'] / $data['currency'];
        
        $cost -> update($data);
        // change created_at if the sale is ago some days
        if($request -> created_at){
            $created_at = $request -> created_at;
            $cost -> created_at = $created_at;
            $cost -> updated_at = $created_at;
            $cost ->save();
        }
        
        return redirect() -> route('costs.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cost  $cost
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cost $cost)
    {
        $cost -> delete();
        return redirect() -> back();
    }
}