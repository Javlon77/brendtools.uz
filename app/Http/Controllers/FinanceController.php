<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\Sales;
use App\Models\SaleProduct;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Cost;
use App\Models\Currency;
use App\Models\Plan;

class FinanceController extends Controller
{
    public function index(){
        return view('finance.index');
    } 

    //plan index
    public function plan(){

        $plans = plan::orderBy('year') -> get();
        return view('finance.plan', compact('plans'));
    }

    //plan save 
    public function storePlan(Request $request){

        $data = $request -> validate([
            'year' => 'unique:plans,year'
        ],
        [
            'year.unique' => $request -> year. ' - yil uchun plan allaqachon mavjud mavjud'
        ]);
        $data['first_plan'] = str_replace(' ', '', $request -> first_plan);
        $data['second_plan'] = str_replace(' ', '', $request -> second_plan);
        $data['annual_plan'] = str_replace(' ', '', $request -> annual_plan);
        
        plan::create($data);
        return redirect() -> back();
    }

    // plan destroy
    public function destroyPlan($id) {
        plan::find($id) -> delete(); 
        return redirect() -> back();
    }

    // annual plan data
    public function annual(Request $request){

        // idientifying year
        if($request -> has('year')){
            $year = $request -> year;
        } else $year = now() -> format('Y');

        // dateas from tables
        $plan = plan::where('year', $year) 
                        ->first() ?? dd('Iltimos oldin yillik planni kiriting ushbu yil uchun: '. $year);
        $costs = Cost::whereYear('created_at', $year)
                        ->get()
                        ->groupBy('month');
        $sales = sales::whereYear('created_at', $year)
                        ->get();
        

        // --------- analyzing data -----------

        // sale by awareness
        $by_awareness=[
            'Google' =>0,
            'Yandex' =>0,
            'Telegram' =>0,
            'Instagram' =>0,
            'Facebook' =>0,
            'Reklama' =>0,
            'Tanish-blish' =>0,
            'Qayta-xarid' =>0,
        ];
        foreach( $sales->groupBy('awareness') as $key => $value){
            $by_awareness[$key]=$value->sum('total_amount');
        }

        // sale by language
        $by_language=[];
        foreach($sales->groupBy('client.language') as $key => $value){
            $by_language[$key] = $value->sum('total_amount');
        }

        // sale by client_type - usta, uy egasi, korxona xodimi
        $by_client_type=[
            'Uy egasi' => 0,
            'Kompaniya xodimi' => 0,
            'Usta' => 0
        ];
        foreach($sales->groupBy('client.type') as $key => $value){
            $by_client_type[$key] = $value->sum('total_amount');
        }

        // sale by gender
        $by_client_gender=[
            'Erkak' => 0,
            'Ayol' => 0,
        ];
        foreach( $sales->groupBy('client.gender') as $key => $value ){
            $by_client_gender[$key] = $value->sum('total_amount');
        }

        // sale by region      
        $by_client_region=[];
        foreach($sales->groupBy('client.region') as $key => $value){
            $by_client_region[$key] = $value->sum('total_amount');
        }
        $by_client_region = collect($by_client_region) 
                            ->sortDesc()
                            ->toarray();

        // sale by product categories
        $categories = Category::get();
        $sold_products = SaleProduct::whereYear('created_at', $year) 
                                    -> with('product') 
                                    -> get();
        $by_category = [];
        foreach($sold_products->groupBy('product.category_id') as $key => $value){
            $by_category[$categories->find($key)->category] = $value
                                                                ->sum(function($value){
                                                                    return $value->selling_price * $value->quantity;
                                                                });
        }
        $by_category = collect($by_category) ->sortDesc() ->toarray();
                        
        // sale by product brand
        $brands = Brand::get();
        $by_brand = [];
        foreach($sold_products->groupBy('product.brand_id') as $key => $value){
            $by_brand[$brands->find($key)->brand] = $value
                                                    ->sum(function($value){
                                                        return $value->selling_price * $value->quantity;
                                                    });
        }
        $by_brand =  collect($by_brand) ->sortDesc() ->toarray();


        // grouping sales by month
        $sales = $sales ->groupBy('month');
        foreach (now()->subMonths(12)->monthsUntil(now()) as $date) {
            $sales[$date->format('n')] = $sales[$date->format('n')] ?? collect([]);
        }
        foreach (now()->subMonths(12)->monthsUntil(now()) as $date) {
            $costs[$date->format('n')] = $costs[$date->format('n')] ?? collect([]);
        }

        // annual_plan totals
        $annual_plan['total_amount'] = 0;
        $annual_plan['total_amount_usd'] = 0;
        $annual_plan['profit'] = 0;
        $annual_plan['profit_usd'] = 0;
        $annual_plan['net_profit'] = 0;
        $annual_plan['net_profit_usd'] = 0;
        $annual_plan['sale_count'] = 0;
        $annual_plan['product_count'] = 0;
        $annual_plan['cost'] = 0;
        $annual_plan['cost_usd'] = 0;
        // first_plan totals
        $first_plan['total_amount'] = 0;
        $first_plan['total_amount_usd'] = 0;
        $first_plan['profit'] = 0;
        $first_plan['profit_usd'] = 0;
        $first_plan['net_profit'] = 0;
        $first_plan['net_profit_usd'] = 0;
        $first_plan['sale_count'] = 0;
        $first_plan['product_count'] = 0;
        $first_plan['cost'] = 0;
        $first_plan['cost_usd'] = 0;
        // second_plan total
        $second_plan['total_amount'] = 0;
        $second_plan['total_amount_usd'] = 0;
        $second_plan['profit'] = 0;
        $second_plan['profit_usd'] = 0;
        $second_plan['net_profit'] = 0;
        $second_plan['net_profit_usd'] = 0;
        $second_plan['sale_count'] = 0;
        $second_plan['product_count'] = 0;
        $second_plan['cost'] = 0;
        $second_plan['cost_usd'] = 0;
        // to divide into month totals
        foreach($sales as $month => $sale){

            $annual_plan['total_amount'] += $sale->sum('total_amount');
            $annual_plan['total_amount_usd'] += $sale->sum('total_amount_usd');
            $annual_plan['profit'] += $sale->sum('profit');
            $annual_plan['profit_usd'] += $sale->sum('profit_usd');
            $annual_plan['net_profit'] += $sale->sum('net_profit');
            $annual_plan['net_profit_usd'] += $sale->sum('net_profit_usd');
            $annual_plan['sale_count'] += $sale->count();
            $annual_plan['product_count'] += $sale->sum('total_quantity');

            if($month<7){
                $first_plan['total_amount'] += $sale->sum('total_amount');
                $first_plan['total_amount_usd'] += $sale->sum('total_amount_usd');
                $first_plan['profit'] += $sale->sum('profit');
                $first_plan['profit_usd'] += $sale->sum('profit_usd');
                $first_plan['net_profit'] += $sale->sum('net_profit');
                $first_plan['net_profit_usd'] += $sale->sum('net_profit_usd');
                $first_plan['sale_count'] += $sale->count();
                $first_plan['product_count'] += $sale->sum('total_quantity');
                
            }

            if($month>6){
                $second_plan['total_amount'] += $sale->sum('total_amount');
                $second_plan['total_amount_usd'] += $sale->sum('total_amount_usd');
                $second_plan['profit'] += $sale->sum('profit');
                $second_plan['profit_usd'] += $sale->sum('profit_usd');
                $second_plan['net_profit'] += $sale->sum('net_profit');
                $second_plan['net_profit_usd'] += $sale->sum('net_profit_usd');
                $second_plan['sale_count'] += $sale->count();
                $second_plan['product_count'] += $sale->sum('total_quantity');
            }
        }

        // calcualting costs totals
        foreach($costs as $month => $cost){ 

            $annual_plan['cost'] += $cost->sum('cost');
            $annual_plan['cost_usd'] += $cost->sum('cost_usd');

            if($month<7){
                $first_plan['cost'] += $cost->sum('cost');
                $first_plan['cost_usd'] += $cost->sum('cost_usd');  
            }

            if($month>6){
                $second_plan['cost'] += $cost->sum('cost');
                $second_plan['cost_usd'] += $cost->sum('cost_usd');  
            }    
        };  

        $annual_plan['cost'] += $annual_plan['profit'] -  $annual_plan['net_profit'];
        $annual_plan['cost_usd'] += $annual_plan['profit_usd'] -  $annual_plan['net_profit_usd'];
        $first_plan['cost'] += $first_plan['profit'] -  $first_plan['net_profit'];
        $first_plan['cost_usd'] += $first_plan['profit_usd'] -  $first_plan['net_profit_usd'];
        $second_plan['cost'] += $second_plan['profit'] -  $second_plan['net_profit'];
        $second_plan['cost_usd'] += $second_plan['profit_usd'] -  $second_plan['net_profit_usd'];
        return view( 'finance.annual',  compact(
                                            'sales',
                                            'costs',
                                            'annual_plan',
                                            'first_plan',
                                            'second_plan', 
                                            'year', 
                                            'plan', 
                                            'by_awareness',
                                            'by_language',
                                            'by_client_type',
                                            'by_client_gender',
                                            'by_client_region',
                                            'by_category',
                                            'by_brand',
                                        ));
    }


    public function brand(Request $request){
     
        $from; // filter from date variable
        $to;  // filter to date variable
        $check; // to idientify and return to blade the datarange
        // filter by option date
        if ( $request->has('order') ) {
            $check = $request-> order;
            switch ($request -> order) {
                case 'today':
                    $from = Carbon::today();
                    $to = Carbon::today() -> endOfDay();
                    break;
                case 'this_week':
                    $from = Carbon::today() -> startOfWeek();
                    $to = Carbon::today() -> endOfweek();
                    break;
                case 'last_week':
                    $from = Carbon::now() -> subWeek() -> startOfWeek();
                    $to =  Carbon::now() -> subWeek() -> endOfWeek();
                    break;
                case 'this_month':
                    $from = Carbon::now() -> startOfMonth();
                    $to =  Carbon::now() -> endOfMonth();
                    break;
                case 'last_month':
                    $from = Carbon::now() -> startOfMonth() -> subMonth();
                    $to =  Carbon::now() -> subMonth() -> endOfMonth();
                    break;
                case 'this_year':
                    $from = Carbon::now() -> startOfYear();
                    $to =  Carbon::now() -> endOfYear();
                    break;
                case 'last_year':
                    $from = Carbon::now() -> startOfYear() -> subYear();
                    $to =  Carbon::now() -> endOfYear() -> subYear();
                    break;
                case 'all':
                    $from = Sales:: oldest() -> first() -> created_at;
                    $to = Sales:: latest() -> first() -> created_at;
                    break;
            }
        } 
        // filter by custom date
        elseif ( $request->has('from') | $request->has('to') ) {
            $request->validate([
                'to' => 'required|date_format:Y-m-d',
                'from' => 'required|date_format:Y-m-d'
            ],
            [
                'from.required'=>"Boshlang'ich sanani kiriting!",
                'to.required'=>"Tugash sanasini kiriting!",
            ]);
            $from = $request -> from .' 00:00:00';
            $to =  $request -> to .' 23:59:59';
            $check = NULL;
        }
        // filter by this week as default
        else {
            $from = Carbon::now() -> startOfMonth();
            $to =  Carbon::now() -> endOfMonth();
            $check = 'this_month';
        }
        
        // All Products
        $products = SaleProduct::whereBetween( 'created_at', [$from, $to] ) 
                                -> with( 'product') 
                                -> get() 
                                -> groupBy('product.brand_id');
        
        // umumiy savdo
        $total_sale = 0;
        foreach($products as $product) {
            $total_sale +=  $product -> sum(function($item){
                                return $item->selling_price * $item->quantity;
                            });
        };
        // umumiy foyda
        $total_profit = 0;
        foreach($products as $product) {
            $total_profit+= $product -> sum(function($item){
                                return ($item->selling_price - $item->cost_price) * $item->quantity;
                            });
        };
        // jami mahsulot
        $total_product = $products -> sum(function($item){ 
                            return $item -> sum('quantity');
                        });
        $brands = Brand::all();
        $from = date( 'Y-m-d', strtotime($from) );
        $to = date( 'Y-m-d', strtotime($to) ); 
        return view( 'finance.brand', compact('products','brands','total_sale', 'total_profit', 'total_product', 'check', 'from', 'to') );
    }

    public function product(Request $request){
        
        if($request->filter_month && $request->filter_year){
            $products = SaleProduct::whereYear('created_at', $request->filter_year)
                                    ->whereMonth('created_at', $request->filter_month)
                                    ->with('product','sale')
                                    ->get();                                    
            return view('sales.ProductFilter', compact('products'));
        }
    }
}