<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\Master;
use App\Models\Client;
use App\Models\Sales;

class ClientController extends Controller
{
    /**
     * search specified resource from storage.
     *
     * @param  \App\Models\Funnel  $funnel
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request){   
        if($request->ajax()){
            $company=Company::get();
            $master=Master::get();
            $search=$request->get('search');
            $client=Client::where('name','like','%' .$search . '%')
            ->orwhere('surname','like','%' .$search . '%')
            ->orwhere('phone1','like','%' .$search . '%')
            ->orwhere('phone2','like','%' .$search . '%') ->get();
            return json_encode([$company ,$client , $master]);
        }
    }
}