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
use App\Models\Feedback;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
 
class SalesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    { 
        $sales= sales::orderBy('created_at','desc')->get(); 
        $clients= client::orderBy('created_at','desc')->get(); 
        $saleProducts= SaleProduct::orderBy('created_at','desc')->get(); 
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
        $date=Carbon::createFromFormat('Y-m-d', $request->created_at)->format('Y-m-d h:i:s');
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
                'created_at' => $date, 
                'updated_at' => $date, 
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
            'additional'=>'',
            'awareness'=>'',
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
        // add extra value
        $data['currency'] = $currency;
        $data['total_amount'] = $total_amount;
        $data['total_amount_usd'] = $data['total_amount'] / $currency;
        $data['total_quantity'] = $total_quantity;
        $data['profit']= $profit;
        $data['profit_usd'] = $data['profit'] / $currency;
        $data['net_profit'] = $profit-$data['delivery_price'] - $data['additional_cost'] + $data['client_delivery_payment'];
        $data['net_profit_usd'] = $data['net_profit'] / $currency;
        $data['created_at'] = $date;
        $data['updated_at'] = $date;
        // create sale in DB
        $sale = sales::create($data);
        // create feedback form for sale in db feedbacks
        $feedback = new Feedback;
        $feedback -> client_id  = $sale['client_id'];
        $feedback -> sale_id    = $sale['id'];
        $feedback -> sale_date  = $sale['created_at'];
        $feedback -> save();
            
        // save products to sales_product database  
        foreach ($products as $product) {
            $product['sale_id'] = $sale->id;
            SaleProduct::create($product);
        }
        return redirect() -> back() -> with('message', 'Sotuv muvafaqqiyatli kiritildi!');
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
    public function edit(Sales $sale)
    {   
        $brands = brand::orderBy('brand')->get();
        $categories = category::orderBy('category')->get();
        $products = SaleProduct::where('sale_id', $sale->id)->with('product')->get();
        $client = Client::find($sale->client_id);
        return view('sales.edit', compact('sale', 'brands', 'categories','products', 'client'));
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
        //sale
        $sale = Sales::find($id);
        //currency 
        $currency = $sale->currency;
        // variables for
        $total_amount=0;
        $total_quantity=0;
        $profit=0;
        $products=[];
        $date=Carbon::createFromFormat('Y-m-d', $request->created_at)->format('Y-m-d h:i:s');
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
                'created_at' => $date, 
                'updated_at' => $date, 
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
            'additional'=>'',
            'awareness'=>'',
        ]);
        $data['delivery_price_usd']=NULL;
        $data['client_delivery_payment_usd']=NULL;
        $data['additional_cost_usd']=NULL;
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
        // add extra value
        $data['currency'] = $currency;
        $data['total_amount'] = $total_amount;
        $data['total_amount_usd'] = $data['total_amount'] / $currency;
        $data['total_quantity'] = $total_quantity;
        $data['profit']= $profit;
        $data['profit_usd'] = $data['profit'] / $currency;
        $data['net_profit'] = $profit-$data['delivery_price'] - $data['additional_cost'] + $data['client_delivery_payment'];
        $data['net_profit_usd'] = $data['net_profit'] / $currency;
        // update sale in DB
        $sale->client_id =$data['client_id'];
        $sale->payment_method =$data['payment_method'];
        $sale->payment =$data['payment'];
        $sale->delivery_method =$data['delivery_method'];
        $sale->delivery_price =$data['delivery_price'];
        $sale->delivery_price_usd =$data['delivery_price_usd'];
        $sale->client_delivery_payment =$data['client_delivery_payment'];
        $sale->client_delivery_payment_usd =$data['client_delivery_payment_usd'];
        $sale->additional_cost =$data['additional_cost'];
        $sale->additional_cost_usd =$data['additional_cost_usd'];
        $sale->total_quantity =$data['total_quantity'];
        $sale->total_amount =$data['total_amount'];
        $sale->total_amount_usd =$data['total_amount_usd'];
        $sale->profit =$data['profit'];
        $sale->profit_usd =$data['profit_usd'];
        $sale->net_profit =$data['net_profit'];
        $sale->net_profit_usd =$data['net_profit_usd'];
        $sale->currency =$data['currency'];
        $sale->additional =$data['additional'];
        $sale->awareness =$data['awareness'];
        $sale->created_at = $date;
        $sale->updated_at = $date;
        $sale->save();
        // create feedback form for sale in db feedbacks
        $feedback = Feedback::where('sale_id', $sale->id)->first();
        $feedback -> update([
            'client_id' => $sale ->client_id,
            'sale_id'   => $sale ->id,
            'sale_date' => $sale ->created_at
        ]);
        // delete old products and save new products to sales_product database  
        SaleProduct::where('sale_id', $sale->id)->delete();
        foreach ($products as $product) {
            $product['sale_id'] = $sale -> id;
            SaleProduct::create($product);
        }
        
        return redirect($request->session() -> get('previous'));
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