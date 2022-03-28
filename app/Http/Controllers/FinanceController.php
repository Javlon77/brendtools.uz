<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\Sales;
use App\Models\SaleProduct;
use App\Models\Product;
use App\Models\Brand;
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
        $month_name = [
            '1' => 'Yanvar',
            '2' => 'Fevral',
            '3' => 'Mart',
            '4' => 'Aprel',
            '5' => 'May',
            '6' => 'Iyyun',
            '7' => 'Iyyul',
            '8' => 'Avgust',
            '9' => 'Sentabr',
            '10' => 'Oktabr',
            '11' => 'Noyabr',
            '12' => 'Dekabr',
        ];
        if($request -> has('year')){
            $year = $request -> year;
        } else $year = now() -> format('Y');

        $plan = plan::where('year', $year) -> first() ?? dd('Iltimos oldin yillik planni kiriting ushbu yil uchun: '. $year);
        $annual_cost = Cost::whereYear('created_at', $year) -> get();
        $costs = $annual_cost ->groupBy('month');
        $sales = sales::whereYear('created_at', $year) -> get();
        $months = $sales -> groupBy('month');
        foreach (now()->subMonths(12)->monthsUntil(now()) as $date) {
            $months[$date->format('m')] = $months[$date->format('m')] ?? collect([]);
        }
        foreach (now()->subMonths(12)->monthsUntil(now()) as $date) {
            $costs[$date->format('m')] = $costs[$date->format('m')] ?? collect([]);
        }
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
        foreach($sales->groupBy('client.gender') as $key => $value){
            $by_client_gender[$key] = $value->sum('total_amount');
        }
         // sale by region
         $by_client_region=[];
        foreach($sales->groupBy('client.region') as $key => $value){
            $by_client_region[$key] = $value->sum('total_amount');
        }
        $by_client_region = collect($by_client_region) ->sortDesc()->toarray();
        
        // first_plan data collect
        $first_plan_array =array_filter($months -> toarray(), fn($key) => $key < 7,ARRAY_FILTER_USE_KEY);
        $first_plan_array = collect($first_plan_array) -> map(function ($name) { return collect($name); });
        $first_plan['total_amount'] = 0;
        $first_plan['total_amount_usd'] = 0;
        $first_plan['profit'] = 0;
        $first_plan['profit_usd'] = 0;
        $first_plan['net_profit'] = 0;
        $first_plan['net_profit_usd'] = 0;
        $first_plan['sale'] = 0;
        $first_plan['product'] = 0;
        
        foreach($first_plan_array as $i){
            $first_plan['total_amount'] += $i -> sum('total_amount');   
            $first_plan['total_amount_usd'] += $i -> sum('total_amount_usd');   
            $first_plan['profit'] += $i -> sum('profit');   
            $first_plan['profit_usd'] += $i -> sum('profit_usd');   
            $first_plan['net_profit'] += $i -> sum('net_profit');   
            $first_plan['net_profit_usd'] += $i -> sum('net_profit_usd');   
            $first_plan['sale'] += $i -> count();   
            $first_plan['product'] += $i -> sum('total_quantity');   
        }
        $first_plan['cost'] = $costs['01']->sum('cost') + $costs['02']->sum('cost') + $costs['03']->sum('cost') + $costs['04']->sum('cost') + $costs['05']->sum('cost') + $costs['06']->sum('cost') + ( $first_plan['profit'] -  $first_plan['net_profit'] );
        $first_plan['cost_usd'] = $costs['01']->sum('cost_usd') + $costs['02']->sum('cost_usd') + $costs['03']->sum('cost_usd') + $costs['04']->sum('cost_usd') + $costs['05']->sum('cost_usd') + $costs['06']->sum('cost_usd') + ( $first_plan['profit_usd'] -  $first_plan['net_profit_usd'] );
        
        // second_plan
        $second_plan_array =array_filter($months -> toarray(), fn($key) => $key > 6,ARRAY_FILTER_USE_KEY);
        $second_plan_array = collect($second_plan_array) -> map(function ($name) { return collect($name); });
        $second_plan['total_amount'] = 0;
        $second_plan['total_amount_usd'] = 0;
        $second_plan['profit'] = 0;
        $second_plan['profit_usd'] = 0;
        $second_plan['net_profit'] = 0;
        $second_plan['net_profit_usd'] = 0;
        $second_plan['sale'] = 0;
        $second_plan['product'] = 0;
        
        foreach($second_plan_array as $i){
            $second_plan['total_amount'] += $i -> sum('total_amount');   
            $second_plan['total_amount_usd'] += $i -> sum('total_amount_usd');   
            $second_plan['profit'] += $i -> sum('profit');   
            $second_plan['profit_usd'] += $i -> sum('profit_usd');   
            $second_plan['net_profit'] += $i -> sum('net_profit');   
            $second_plan['net_profit_usd'] += $i -> sum('net_profit_usd');   
            $second_plan['sale'] += $i -> count();   
            $second_plan['product'] += $i -> sum('total_quantity');   
        }
        $second_plan['cost'] = $costs['07']->sum('cost') + $costs['08']->sum('cost') + $costs['09']->sum('cost') + $costs['10']->sum('cost') + $costs['11']->sum('cost') + $costs['12']->sum('cost') + ( $second_plan['profit'] -  $second_plan['net_profit'] );
        $second_plan['cost_usd'] = $costs['07']->sum('cost_usd') + $costs['08']->sum('cost_usd') + $costs['09']->sum('cost_usd') + $costs['10']->sum('cost_usd') + $costs['11']->sum('cost_usd') + $costs['12']->sum('cost_usd') + ( $second_plan['profit_usd'] -  $second_plan['net_profit_usd'] );

        return view('finance.annual', compact(
                        'month_name', 
                        'sales',
                        'months',
                        'first_plan',
                        'second_plan', 
                        'costs',
                        'annual_cost',
                        'year', 
                        'plan', 
                        'by_awareness',
                        'by_language',
                        'by_client_type',
                        'by_client_gender',
                        'by_client_region',
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
                $total_sale+= $product -> sum(function($item){
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
        $total_product = $products -> sum(function($item){ return $item -> sum('quantity');});

        $brands = Brand::all();
        $from = date( 'Y-m-d', strtotime($from) );
        $to = date( 'Y-m-d', strtotime($to) );
        return view( 'finance.brand', compact('products','brands','total_sale', 'total_profit', 'total_product', 'check', 'from', 'to') );
    }
}