<?php

namespace App\Http\Controllers;

use App\Models\Funnel;
use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Company;
use App\Models\Master;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class FunnelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) 
    {   
        $token = $request->user()->api_token;
        $clients = client::get();
        $status1 = Funnel::where('status', 'Birinchi suhbat')->orderBy('updated_at', 'DESC');
        $status2 = Funnel::where('status', "Ko'ndirish jarayoni")->orderBy('updated_at', 'DESC');
        $status3 = Funnel::where('status', "Bitm tuzildi")->orderBy('updated_at', 'DESC');
        $status4 = Funnel::where('status', "To'lov qilindi")->orderBy('updated_at', 'DESC');
        $status5 = Funnel::where('status', "Yakunlandi")->orderBy('updated_at', 'DESC');
        $status6 = Funnel::where('status', "Qaytarib berildi")->orderBy('updated_at', 'DESC');
        
        //vaqt oralig'i boyicha saralash  
        if($request->has('filterFrom')){
            $data = $request->validate([
                'filterTo' => 'required|date_format:Y-m-d',
                'filterFrom' => 'required|date_format:Y-m-d'
            ],
            [
                'filterFrom.required'=>"Boshlang'ich sanani kiriting!",
                'filterTo.required'=>"Tugash sanasini kiriting!",
            ]);
            
            $status1=$status1->whereDate('updated_at', '>=', $request->filterFrom)->whereDate('updated_at', '<=', $request->filterTo)->get();
            $status2=$status2->whereDate('updated_at', '>=', $request->filterFrom)->whereDate('updated_at', '<=', $request->filterTo)->get();
            $status3=$status3->whereDate('updated_at', '>=', $request->filterFrom)->whereDate('updated_at', '<=', $request->filterTo)->get();
            $status4=$status4->whereDate('updated_at', '>=', $request->filterFrom)->whereDate('updated_at', '<=', $request->filterTo)->get();
            $status5=$status5->whereDate('updated_at', '>=', $request->filterFrom)->whereDate('updated_at', '<=', $request->filterTo)->get();
            $status6=$status6->whereDate('updated_at', '>=', $request->filterFrom)->whereDate('updated_at', '<=', $request->filterTo)->get();
            $filterFrom = $request->filterFrom;
            $filterTo = $request->filterTo;
            return view('funnel.index',compact('token','clients','status1','status2','status3','status4','status5','status6','filterFrom','filterTo'));
        }
       
        // sort by order
        if($request->has('order')) {
            //bugun
            if($request->order=='today'){

                $status1=$status1->where('updated_at', '>=', Carbon::today())->get();
                $status2=$status2->where('updated_at', '>=', Carbon::today())->get();
                $status3=$status3->where('updated_at', '>=', Carbon::today())->get();
                $status4=$status4->where('updated_at', '>=', Carbon::today())->get();
                $status5=$status5->where('updated_at', '>=', Carbon::today())->get();
                $status6=$status6->where('updated_at', '>=', Carbon::today())->get();
                $date = $request->order;
                return view('funnel.index',compact('token','clients','status1','status2','status3','status4','status5','status6', 'date'));
            }
            //shu hafta
            elseif($request->order=='thisWeek'){
                
                $status1=$status1->whereDate('updated_at', '>=', Carbon::now()->startOfWeek())->get();
                $status2=$status2->whereDate('updated_at', '>=', Carbon::now()->startOfWeek())->get();
                $status3=$status3->whereDate('updated_at', '>=', Carbon::now()->startOfWeek())->get();
                $status4=$status4->whereDate('updated_at', '>=', Carbon::now()->startOfWeek())->get();
                $status5=$status5->whereDate('updated_at', '>=', Carbon::now()->startOfWeek())->get();
                $status6=$status6->whereDate('updated_at', '>=', Carbon::now()->startOfWeek())->get();
                $date = $request->order;
                return view('funnel.index',compact('token','clients','status1','status2','status3','status4','status5','status6', 'date'));
            }
            //o'tkan hafta   
            elseif($request->order=='lastWeek'){
                
                $status1=$status1->whereBetween('updated_at',[Carbon::now()->subWeek()->startOfWeek(), Carbon::now()->subWeek()->endOfWeek()])->get();
                $status2=$status2->whereBetween('updated_at',[Carbon::now()->subWeek()->startOfWeek(), Carbon::now()->subWeek()->endOfWeek()])->get();
                $status3=$status3->whereBetween('updated_at',[Carbon::now()->subWeek()->startOfWeek(), Carbon::now()->subWeek()->endOfWeek()])->get();
                $status4=$status4->whereBetween('updated_at',[Carbon::now()->subWeek()->startOfWeek(), Carbon::now()->subWeek()->endOfWeek()])->get();
                $status5=$status5->whereBetween('updated_at',[Carbon::now()->subWeek()->startOfWeek(), Carbon::now()->subWeek()->endOfWeek()])->get();
                $status6=$status6->whereBetween('updated_at',[Carbon::now()->subWeek()->startOfWeek(), Carbon::now()->subWeek()->endOfWeek()])->get();
                $date = $request->order;
                return view('funnel.index',compact('token','clients','status1','status2','status3','status4','status5','status6', 'date'));
            }
            //shu oy   
            elseif($request->order=='thisMonth'){
                
                $status1=$status1->whereYear('updated_at', date('Y'))->whereMonth('updated_at', Carbon::now()->month)->get();
                $status2=$status2->whereYear('updated_at', date('Y'))->whereMonth('updated_at', Carbon::now()->month)->get();
                $status3=$status3->whereYear('updated_at', date('Y'))->whereMonth('updated_at', Carbon::now()->month)->get();
                $status4=$status4->whereYear('updated_at', date('Y'))->whereMonth('updated_at', Carbon::now()->month)->get();
                $status5=$status5->whereYear('updated_at', date('Y'))->whereMonth('updated_at', Carbon::now()->month)->get();
                $status6=$status6->whereYear('updated_at', date('Y'))->whereMonth('updated_at', Carbon::now()->month)->get();
                $date = $request->order;
                return view('funnel.index',compact('token','clients','status1','status2','status3','status4','status5','status6', 'date'));
            }
            //o'tkan oy   
            elseif($request->order=='lastMonth'){
               
                $start = Carbon::now() -> startOfMonth() -> subMonth();
                $end = Carbon::now() -> subMonth() -> endOfMonth();
              
                $status1=$status1 -> whereBetween( 'updated_at', [$start ,$end] ) -> get();
                $status2=$status2 -> whereBetween( 'updated_at', [$start ,$end] ) -> get();
                $status3=$status3 -> whereBetween( 'updated_at', [$start ,$end] ) -> get();
                $status4=$status4 -> whereBetween( 'updated_at', [$start ,$end] ) -> get();
                $status5=$status5 -> whereBetween( 'updated_at', [$start ,$end] ) -> get();
                $status6=$status6 -> whereBetween( 'updated_at', [$start ,$end] ) -> get();
                
                $date = $request->order;
                return view('funnel.index',compact('token','clients','status1','status2','status3','status4','status5','status6', 'date'));
            }
            //shu yil   
            elseif($request->order=='thisYear'){
                
                $status1=$status1->whereYear('updated_at', date('Y'))->get();
                $status2=$status2->whereYear('updated_at', date('Y'))->get();
                $status3=$status3->whereYear('updated_at', date('Y'))->get();
                $status4=$status4->whereYear('updated_at', date('Y'))->get();
                $status5=$status5->whereYear('updated_at', date('Y'))->get();
                $status6=$status6->whereYear('updated_at', date('Y'))->get();
                $date = $request->order;
                return view('funnel.index',compact('token','clients','status1','status2','status3','status4','status5','status6', 'date'));
            }
            //o'tkan yil   
            elseif($request->order=='lastYear'){
                $status1=$status1->whereYear('updated_at', date('Y')-1)->get();
                $status2=$status2->whereYear('updated_at', date('Y')-1)->get();
                $status3=$status3->whereYear('updated_at', date('Y')-1)->get();
                $status4=$status4->whereYear('updated_at', date('Y')-1)->get();
                $status5=$status5->whereYear('updated_at', date('Y')-1)->get();
                $status6=$status6->whereYear('updated_at', date('Y')-1)->get();
                $date = $request->order;
                return view('funnel.index',compact('token','clients','status1','status2','status3','status4','status5','status6', 'date'));
            }
            //hammasi
            elseif($request->order=='all'){
                $status1=$status1->get();
                $status2=$status2->get();
                $status3=$status3->get();
                $status4=$status4->get();
                $status5=$status5->get();
                $status6=$status6->get();
                $date = $request->order;
                return view('funnel.index',compact('token','clients','status1','status2','status3','status4','status5','status6', 'date'));
            }
            
        }

        $status1=$status1->whereDate('updated_at', '>=', Carbon::now()->startOfWeek())->get();
        $status2=$status2->whereDate('updated_at', '>=', Carbon::now()->startOfWeek())->get();
        $status3=$status3->whereDate('updated_at', '>=', Carbon::now()->startOfWeek())->get();
        $status4=$status4->whereDate('updated_at', '>=', Carbon::now()->startOfWeek())->get();
        $status5=$status5->whereDate('updated_at', '>=', Carbon::now()->startOfWeek())->get();
        $status6=$status6->whereDate('updated_at', '>=', Carbon::now()->startOfWeek())->get();
        return view('funnel.index',compact('token','clients','status1','status2','status3','status4','status5','status6'));
  
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $clients = Client::orderBy('id')->get();
        return view('funnel.create',compact('clients'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request);
        $data = $request->validate([
            'client_id'=>'required',
            'status'=>'',
            'awareness'=>'',
            'price'=>'',
            'product'=>'',
            'additional'=>'',
        ],
        [
            'client_id.required'=>'Iltimos mijozni tanlang!'
        ]);
        $data['created_at'] = $request->created_at;
        $data['updated_at'] = $request->created_at;
        
        if($data['price']!==NULL){
            $data['price']=str_replace(' ', '', $data['price']);
        } 
        
        Funnel::create($data);
 
        return redirect()->back()->with('success', 'Mufaqqaiyatli saqlandi!');
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Funnel  $funnel
     * @return \Illuminate\Http\Response
     */
    public function show(Funnel $funnel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Funnel  $funnel
     * @return \Illuminate\Http\Response
     */
    public function edit(Funnel $funnel)
    {
        $clients = Client::orderBy('id')->get();
        return view('funnel.edit',compact('funnel','clients'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Funnel  $funnel
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Funnel $funnel)
    {
       
        $data = $request->validate([
            'client_id'=>'required',
            'status'=>'',
            'awareness'=>'',
            'price'=>'',
            'product'=>'',
            'additional'=>''
        ],
        [
            'client_id.required'=>'Iltimos mijozni tanlang!'
        ]);
        $data['created_at'] = $request->created_at;
        $data['updated_at'] = $request->created_at;

        if($data['price']!==NULL){
            $data['price']=str_replace(' ', '', $data['price']);
        }
        
        $funnel = funnel::find($funnel->id);
        $funnel->update($data);
        return redirect($request->session() -> get('previous')) ;
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Funnel  $funnel
     * @return \Illuminate\Http\Response
     */
    public function destroy(Funnel $funnel)
    {
        //
    }
 
}