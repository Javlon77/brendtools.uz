<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Sales;
use App\Models\Client;
use App\Models\Company;
use App\Models\Master;
use App\Models\Currency;
use App\Models\SaleProduct;
 
class SalesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sales= sales::orderBy('updated_at','desc')->get(); 
        $clients= client::orderBy('updated_at','desc')->get(); 
        $saleProducts= SaleProduct::orderBy('updated_at','desc')->get(); 
        return view('sales.index', compact('sales','clients','saleProducts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $brands= brand::orderBy('brand')->get();
        $categories= category::orderBy('category')->get();
        return view('sales.create',compact('brands', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */ 
    public function store(Request $request)
    {   
        //currency 
        $currency = currency::latest()->first()->currency;
        
         
        // variables for
        $total_amount=0;
        $total_quantity=0;
        $profit=0;
        $products=[];

        // loop to create products array
        for ( $i=0; $i < count($request->product_id); $i++ ){
            $product=[
                'sale_id' => '1',
                'product_id' => $request->product_id[$i],
                'quantity' => $request->quantity[$i], 
                'cost_price' => str_replace(' ', '', $request->cost_price[$i]),
                'cost_price_usd' => str_replace(' ', '', $request->cost_price[$i]) / $currency,
                'selling_price' => str_replace(' ', '', $request->selling_price[$i]), 
                'selling_price_usd' => str_replace(' ', '', $request->selling_price[$i]) / $currency, 
                'currency' => $currency, 
            ];
            $total_amount+= $product['selling_price'] * $product['quantity'];
            $total_quantity+= $product['quantity'];
            $profit+= ( $product['selling_price'] - $product['cost_price'] ) * $product['quantity'];
            $products[]=$product;
        }

        // validation
        $data=$request->validate([
            'payment_method'=>'',
            'payment'=>'',
            'client_id'=>'',
            'delivery_method'=>'',
            'delivery_price'=>'',
            'client_delivery_payment'=>'',
            'additional_cost'=>'',
            'additional'=>''
        ]);

        // remove whitespaces from validation array
        if($data['delivery_price']!==NULL){
            $data['delivery_price'] = str_replace(' ', '', $data['delivery_price']);
            $data['delivery_price_usd'] = $data['delivery_price'] / $currency;
        }
        if($data['client_delivery_payment']!==NULL){
            $data['client_delivery_payment'] = str_replace(' ', '', $data['client_delivery_payment']);
            $data['client_delivery_payment_usd'] = $data['client_delivery_payment']  / $currency;
        }
        if($data['additional_cost']!==NULL){
            $data['additional_cost'] = str_replace(' ', '', $data['additional_cost']);
            $data['additional_cost_usd'] = $data['additional_cost'] / $currency;
        }

        // add value
        $data['currency'] = $currency;
        $data['total_amount'] = $total_amount;
        $data['total_amount_usd'] = $data['total_amount'] / $currency;
        $data['total_quantity'] = $total_quantity;
        $data['profit']= $profit;
        $data['profit_usd'] = $data['profit'] / $currency;
        $data['net_profit'] = $profit-$data['delivery_price'] - $data['additional_cost'] + $data['client_delivery_payment'];
        $data['net_profit_usd'] = $data['net_profit'] / $currency;
        
        
        // create sale in DB
        $sale_id = sales::create($data);    
        $sale_id = $sale_id['id'];

        // save products to sales_product database  
        foreach ($products as $p) {
            $p['sale_id']=$sale_id;
            SaleProduct::create($p);
        }

        // return redirect() -> back() -> with('message', 'Sotuv muvafaqqiyatli kiritildi!');

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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        saleProduct::where('sale_id', $id)->delete();
        Sales::find($id)->delete();
        return redirect()->back();
    }
}