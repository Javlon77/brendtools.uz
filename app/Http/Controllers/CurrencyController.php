<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CurrencyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {  
        $last_currency= currency::latest()->first();
        $currencies = currency::latest()->get();
        return view('currency.index', compact('last_currency','currencies'));
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
        $currency = $request -> validate([
            'currency' => 'required'
        ]);
        $currency = str_replace(' ', '', $currency);
        //  update last currency updated_at
        if(!empty(currency::latest()->first())){
            currency::latest()->first()->touch();
        }

        // save currency also for brandtools.uz ecommerce website
        $value = $currency['currency'];
        $response = Http::get('https://brandtools.uz/wp-json/currency-change/currency?value='. $value .'&password=l8MJKTOm^(D123.1*!$%@$@d3^PHb)(6L');
        if( $response->body() == 1){
            currency::create($currency);
            return redirect()->back()->with('success', 'Muvaffaqqiyatli saqlandi!');
        }
        else{
            return redirect()->back()->with('error', 'Tizimda hatolik!');
        };
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Currency  $currency
     * @return \Illuminate\Http\Response
     */
    public function show(Currency $currency)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Currency  $currency
     * @return \Illuminate\Http\Response
     */
    public function edit(Currency $currency)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Currency  $currency
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Currency $currency)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Currency  $currency
     * @return \Illuminate\Http\Response
     */
    public function destroy(Currency $currency)
    {
        //
    }
}
