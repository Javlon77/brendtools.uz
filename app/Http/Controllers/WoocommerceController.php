<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Automattic\WooCommerce\Client;
use Illuminate\Pagination\Paginator;

class WoocommerceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $woocommerce = new Client(
        'http://brandtools.uz',
        'ck_216ea72f3ed20157c34430235c88d16af924e17b',
        'cs_9365d5cc3e913c5a41c9f68d622b3cbf1d10d57d',
        [
            'wp_api' => true,
            'version' => 'wc/v3',
            'timeout' => '1000'
        ]
        );
    
        // categories list
        $categories = $woocommerce->get('products/categories', [
            'per_page'=>'100',
        ]);
    
        // brands list
        $brands = $woocommerce->get('products/attributes/113/terms/', [
            'per_page'=>'100',
        ]);
        
        $filter_brand ='';
        if(isset($request-> brand)){
            $filter_brand = $request-> brand;
        }
        $filter_category ='';
        if(isset($request-> category)){
            $filter_category = $request-> category;
        }
        $page_number = 1;
        if(isset($request-> page)){
            $page_number = $request-> page;
        }
        $on_sale = '';
        $check_on_sale = 'error';
        if(isset($request-> on_sale) ){
            $on_sale = $request-> on_sale;
            $check_on_sale = 'on_sale';
        }
        // min and max price
        $check_min_price = 'false';
        $min_price = '';
        if(isset($request->min_price) ){
            $min_price = $request->min_price;
            $check_min_price = 'min_price';
        }

        $check_max_price = 'false';
        $max_price = '';
        if(isset($request->max_price) ){
            $max_price = $request->max_price;
            $check_max_price = 'max_price';
        }

        $products = $woocommerce->get( 'products', [
            'context' => 'edit',
            'orderby' => 'id',
            $check_min_price => $min_price,
            $check_max_price => $max_price,
            'status' => 'publish',
            $check_on_sale => 'true',
            'page' => $page_number,
            'per_page' => '100',
            'category' => $filter_category,
            'attribute' => 'pa_brand',
            'attribute_term' => $filter_brand ,
        ]);
        $page_count = $woocommerce->http->getResponse()->getHeaders()['X-WP-TotalPages'];
        $product_count = $woocommerce->http->getResponse()->getHeaders()['X-WP-Total'];
        $prev = route('woocommerce.index').'?brand='.$filter_brand.'&category='.$filter_category.'&min_price='.$min_price.'&max_price='.$max_price.'&on_sale='.$on_sale.'&page='.($page_number-1);
        $next = route('woocommerce.index').'?brand='.$filter_brand.'&category='.$filter_category.'&min_price='.$min_price.'&max_price='.$max_price.'&on_sale='.$on_sale.'&page='.($page_number+1);

        return view('woocommerce.index', compact(
            'brands', 
            'filter_brand',
            'categories', 
            'filter_category', 
            'on_sale', 
            'products', 
            'page_count',
            'page_number',
            'product_count',
            'min_price',
            'max_price',
            'prev',
            'next'

        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(isset($request->update)){
            // check which products selected to update
            $ids = $request->update;
            $products = [];
            foreach($ids as $id){
                $product = array();
                // id
                $product['id'] = $id;
                // name
                $name = 'name_'.$id;
                $product['name'] = $request->$name;
                // regular_price
                $regular_price = 'regular_price_'.$id;
                $product['regular_price'] = $request->$regular_price;
                // date_on_sale_from
                $date_on_sale_from = 'date_on_sale_from_'.$id;
                if($request->$date_on_sale_from !== null) {
                    $product['date_on_sale_from'] = $request->$date_on_sale_from;
                }else{
                    $product['date_on_sale_from'] = '';
                }
                // date_on_sale_to
                $date_on_sale_to = 'date_on_sale_to_'.$id;
                if($request->$date_on_sale_to !== null) {
                    $product['date_on_sale_to'] = $request->$date_on_sale_to .'T23:59:59';
                }else{
                    $product['date_on_sale_to'] = '';
                }
                // sale_price
                $sale_price = 'sale_price_'.$id;
                if($request->$sale_price !== null) {
                    $product['sale_price'] = $request->$sale_price;
                    if($request->$sale_price > $request->$regular_price){
                        $product['date_on_sale_from'] = '';
                        $product['date_on_sale_to'] = '';
                        $product['sale_price'] = '';
                    }
                }else{
                    $product['date_on_sale_from'] = '';
                    $product['date_on_sale_to'] = '';
                    $product['sale_price'] = '';
                }
                // add all collected value to products array
                array_push($products, $product);
            }

            $update = [
                'update' => $products,
            ];
            $woocommerce = new Client(
                'http://brandtools.uz',
                'ck_216ea72f3ed20157c34430235c88d16af924e17b',
                'cs_9365d5cc3e913c5a41c9f68d622b3cbf1d10d57d',
                [
                    'wp_api' => true,
                    'version' => 'wc/v3',
                    'timeout' => '1000'
                ]
            );
            $woocommerce->post('products/batch', $update);
            return redirect()->back()->with('message', 'Все данные успешно изменены!');
        }else{
            dd('Tizimda xatolik bor! +998 97 155 9007');
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
        //
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
        //
    }
}