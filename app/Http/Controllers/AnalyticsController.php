<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Funnel;


class AnalyticsController extends Controller
{
    public function index() {
        return view('analytics.index');
    }
    
    public function funnel(Request $request) {
        // Ozgaruvchilar

        $s1 = Funnel::where('status', 'Birinchi suhbat')->orderBy('updated_at', 'DESC');
        $s2 = Funnel::where('status', "Ko'ndirish jarayoni")->orderBy('updated_at', 'DESC');
        $s3 = Funnel::where('status', "Bitm tuzildi")->orderBy('updated_at', 'DESC');
        $s4 = Funnel::where('status', "To'lov qilindi")->orderBy('updated_at', 'DESC');
        $s5 = Funnel::where('status', "Yakunlandi")->orderBy('updated_at', 'DESC');
        $s6 = Funnel::where('status', "Qaytarib berildi")->orderBy('updated_at', 'DESC');

        //vaqt oralig'i boyicha saralash  -- custom
        if($request->has('filterFrom')){
            $data = $request->validate([
                'filterTo' => 'required|date_format:Y-m-d',
                'filterFrom' => 'required|date_format:Y-m-d'
            ],
            [
                'filterFrom.required'=>"Boshlang'ich sanani kiriting!",
                'filterTo.required'=>"Tugash sanasini kiriting!",
            ]);

            $s1 = $s1 -> whereDate('updated_at', '>=', $request->filterFrom) -> whereDate('updated_at', '<=', $request->filterTo) -> get();
            $s2 = $s2 -> whereDate('updated_at', '>=', $request->filterFrom) -> whereDate('updated_at', '<=', $request->filterTo) -> get();
            $s3 = $s3 -> whereDate('updated_at', '>=', $request->filterFrom) -> whereDate('updated_at', '<=', $request->filterTo) -> get();
            $s4 = $s4 -> whereDate('updated_at', '>=', $request->filterFrom) -> whereDate('updated_at', '<=', $request->filterTo) -> get();
            $s5 = $s5 -> whereDate('updated_at', '>=', $request->filterFrom) -> whereDate('updated_at', '<=', $request->filterTo) -> get();
            $s6 = $s6 -> whereDate('updated_at', '>=', $request->filterFrom) -> whereDate('updated_at', '<=', $request->filterTo) -> get();

            // awarennes count
            $awareness['Google'] = funnel::where('awareness', 'Google') -> whereDate('updated_at', '>=', $request->filterFrom) -> whereDate('updated_at', '<=', $request->filterTo) ->count();
            $awareness['Yandex'] = funnel::where('awareness', 'Yandex') -> whereDate('updated_at', '>=', $request->filterFrom) -> whereDate('updated_at', '<=', $request->filterTo) ->count();
            $awareness['Telegram'] = funnel::where('awareness', 'Telegram') -> whereDate('updated_at', '>=', $request->filterFrom) -> whereDate('updated_at', '<=', $request->filterTo) ->count();
            $awareness['Instagram'] = funnel::where('awareness', 'Instagram') -> whereDate('updated_at', '>=', $request->filterFrom) -> whereDate('updated_at', '<=', $request->filterTo) ->count();
            $awareness['Facebook'] = funnel::where('awareness', 'Facebook') -> whereDate('updated_at', '>=', $request->filterFrom) -> whereDate('updated_at', '<=', $request->filterTo) ->count();
            $awareness['Reklama'] = funnel::where('awareness', 'Reklama') -> whereDate('updated_at', '>=', $request->filterFrom) -> whereDate('updated_at', '<=', $request->filterTo) ->count();
            $awareness['Tanish-blish'] = funnel::where('awareness', 'Tanish-blish') -> whereDate('updated_at', '>=', $request->filterFrom) -> whereDate('updated_at', '<=', $request->filterTo) ->count();
            $awareness['Qayta-xarid'] = funnel::where('awareness', 'Qayta-xarid') -> whereDate('updated_at', '>=', $request->filterFrom) -> whereDate('updated_at', '<=', $request->filterTo) ->count();
          
            // total funnel MONEY
            $s1m = 0; foreach ($s1 as $i) $s1m += $i -> price;
            $s2m = 0; foreach ($s2 as $i) $s2m += $i -> price;
            $s3m = 0; foreach ($s3 as $i) $s3m += $i -> price;
            $s4m = 0; foreach ($s4 as $i) $s4m += $i -> price;
            $s5m = 0; foreach ($s5 as $i) $s5m += $i -> price;
            $s6m = 0; foreach ($s6 as $i) $s6m += $i -> price;

            $allM = array();
            array_push($allM, $s1m, $s2m, $s3m, $s4m, $s5m, $s6m);

            // total each stage funnel COUNT
            $s1t = $s1 -> count();
            $s2t = $s2 -> count();
            $s3t = $s3 -> count();
            $s4t = $s4 -> count();
            $s5t = $s5 -> count();
            $s6t = $s6 -> count();
            
            $allS = array() ;
            array_push($allS, $s1t, $s2t, $s3t, $s4t, $s5t, $s6t);

            // total stage funnel COUNT
            $s1d = $s1t + $s2t + $s3t + $s4t + $s5t + $s6t;
            $s2d = $s1d - $s1t;
            $s3d = $s1d - $s1t - $s2t;
            $s4d = $s1d - $s1t - $s2t -$s3t;
            $s5d = $s1d - $s1t - $s2t -$s3t - $s4t;
            $s6d = $s1d - $s1t - $s2t -$s3t - $s4t - $s5t;

            $allD = array() ;
            array_push($allD, $s1d, $s2d, $s3d, $s4d, $s5d, $s6d);

             // filter  vaqtlari
             $filterFrom = $request->filterFrom;
             $filterTo = $request->filterTo;
            return view('analytics.funnel',compact('allD', 'allM', 'allS','awareness', 'filterFrom','filterTo'));
       
        }
       
        // sort by order
        if($request->has('order')) {

            //bugun
            if($request->order=='today'){
                
                $s1 = $s1 -> where('updated_at', '>=', Carbon::today()) -> get();
                $s2 = $s2 -> where('updated_at', '>=', Carbon::today()) -> get();
                $s3 = $s3 -> where('updated_at', '>=', Carbon::today()) -> get();
                $s4 = $s4 -> where('updated_at', '>=', Carbon::today()) -> get();
                $s5 = $s5 -> where('updated_at', '>=', Carbon::today()) -> get();
                $s6 = $s6 -> where('updated_at', '>=', Carbon::today()) -> get();

                // awarennes count
                $awareness['Google'] = funnel::where('awareness', 'Google') -> where('updated_at', '>=', Carbon::today()) ->count();
                $awareness['Yandex'] = funnel::where('awareness', 'Yandex') -> where('updated_at', '>=', Carbon::today()) ->count();
                $awareness['Telegram'] = funnel::where('awareness', 'Telegram') -> where('updated_at', '>=', Carbon::today()) ->count();
                $awareness['Instagram'] = funnel::where('awareness', 'Instagram') -> where('updated_at', '>=', Carbon::today()) ->count();
                $awareness['Facebook'] = funnel::where('awareness', 'Facebook') -> where('updated_at', '>=', Carbon::today()) ->count();
                $awareness['Reklama'] = funnel::where('awareness', 'Reklama') -> where('updated_at', '>=', Carbon::today()) ->count();
                $awareness['Tanish-blish'] = funnel::where('awareness', 'Tanish-blish') -> where('updated_at', '>=', Carbon::today()) ->count();
                $awareness['Qayta-xarid'] = funnel::where('awareness', 'Qayta-xarid') -> where('updated_at', '>=', Carbon::today()) ->count();

                // total funnel MONEY
                $s1m = 0; foreach ($s1 as $i) $s1m += $i -> price;
                $s2m = 0; foreach ($s2 as $i) $s2m += $i -> price;
                $s3m = 0; foreach ($s3 as $i) $s3m += $i -> price;
                $s4m = 0; foreach ($s4 as $i) $s4m += $i -> price;
                $s5m = 0; foreach ($s5 as $i) $s5m += $i -> price;
                $s6m = 0; foreach ($s6 as $i) $s6m += $i -> price;

                $allM = array();
                array_push($allM, $s1m, $s2m, $s3m, $s4m, $s5m, $s6m);

                // total each stage funnel COUNT
                $s1t = $s1 -> count();
                $s2t = $s2 -> count();
                $s3t = $s3 -> count();
                $s4t = $s4 -> count();
                $s5t = $s5 -> count();
                $s6t = $s6 -> count();
                
                $allS = array() ;
                array_push($allS, $s1t, $s2t, $s3t, $s4t, $s5t, $s6t);

                // total stage funnel COUNT
                $s1d = $s1t + $s2t + $s3t + $s4t + $s5t + $s6t;
                $s2d = $s1d - $s1t;
                $s3d = $s1d - $s1t - $s2t;
                $s4d = $s1d - $s1t - $s2t -$s3t;
                $s5d = $s1d - $s1t - $s2t -$s3t - $s4t;
                $s6d = $s1d - $s1t - $s2t -$s3t - $s4t - $s5t;

                $allD = array() ;
                array_push($allD, $s1d, $s2d, $s3d, $s4d, $s5d, $s6d);
                // END  
                $date = $request->order;

                return view('analytics.funnel',compact('allD', 'allM', 'allS', 'awareness', 'date'));
            }
            
            //shu hafta
            elseif($request->order=='thisWeek'){
                
                $s1=$s1->whereDate('updated_at', '>=', Carbon::now()->startOfWeek()) -> get();
                $s2=$s2->whereDate('updated_at', '>=', Carbon::now()->startOfWeek()) -> get();
                $s3=$s3->whereDate('updated_at', '>=', Carbon::now()->startOfWeek()) -> get();
                $s4=$s4->whereDate('updated_at', '>=', Carbon::now()->startOfWeek()) -> get();
                $s5=$s5->whereDate('updated_at', '>=', Carbon::now()->startOfWeek()) -> get();
                $s6=$s6->whereDate('updated_at', '>=', Carbon::now()->startOfWeek()) -> get();

                // awarennes count
                $awareness['Google'] = funnel::where('awareness', 'Google') -> whereDate( 'updated_at', '>=', Carbon::now() -> startOfWeek() ) ->count();
                $awareness['Yandex'] = funnel::where('awareness', 'Yandex') -> whereDate( 'updated_at', '>=', Carbon::now() -> startOfWeek() ) ->count();
                $awareness['Telegram'] = funnel::where('awareness', 'Telegram') -> whereDate( 'updated_at', '>=', Carbon::now() -> startOfWeek() ) ->count();
                $awareness['Instagram'] = funnel::where('awareness', 'Instagram') -> whereDate( 'updated_at', '>=', Carbon::now() -> startOfWeek() ) ->count();
                $awareness['Facebook'] = funnel::where('awareness', 'Facebook') -> whereDate( 'updated_at', '>=', Carbon::now() -> startOfWeek() ) ->count();
                $awareness['Reklama'] = funnel::where('awareness', 'Reklama') -> whereDate( 'updated_at', '>=', Carbon::now() -> startOfWeek() ) ->count();
                $awareness['Tanish-blish'] = funnel::where('awareness', 'Tanish-blish') -> whereDate( 'updated_at', '>=', Carbon::now() -> startOfWeek() ) ->count();
                $awareness['Qayta-xarid'] = funnel::where('awareness', 'Qayta-xarid') -> whereDate( 'updated_at', '>=', Carbon::now() -> startOfWeek() ) ->count();

               
                // total funnel MONEY
                $s1m = 0; foreach ($s1 as $i) $s1m += $i -> price;
                $s2m = 0; foreach ($s2 as $i) $s2m += $i -> price;
                $s3m = 0; foreach ($s3 as $i) $s3m += $i -> price;
                $s4m = 0; foreach ($s4 as $i) $s4m += $i -> price;
                $s5m = 0; foreach ($s5 as $i) $s5m += $i -> price;
                $s6m = 0; foreach ($s6 as $i) $s6m += $i -> price;

                $allM = array();
                array_push($allM, $s1m, $s2m, $s3m, $s4m, $s5m, $s6m);

                // total each stage funnel COUNT
                $s1t = $s1 -> count();
                $s2t = $s2 -> count();
                $s3t = $s3 -> count();
                $s4t = $s4 -> count();
                $s5t = $s5 -> count();
                $s6t = $s6 -> count();
                
                $allS = array() ;
                array_push($allS, $s1t, $s2t, $s3t, $s4t, $s5t, $s6t);

                // total stage funnel COUNT
                $s1d = $s1t + $s2t + $s3t + $s4t + $s5t + $s6t;
                $s2d = $s1d - $s1t;
                $s3d = $s1d - $s1t - $s2t;
                $s4d = $s1d - $s1t - $s2t -$s3t;
                $s5d = $s1d - $s1t - $s2t -$s3t - $s4t;
                $s6d = $s1d - $s1t - $s2t -$s3t - $s4t - $s5t;

                $allD = array() ;
                array_push($allD, $s1d, $s2d, $s3d, $s4d, $s5d, $s6d);
                // END  
                $date = $request->order;

                return view('analytics.funnel',compact('allD', 'allM', 'allS', 'awareness', 'date'));
            }

            //o'tkan hafta   
            elseif($request->order=='lastWeek'){
                $s1 = $s1 -> whereBetween('updated_at',[Carbon::now()->subWeek()->startOfWeek(), Carbon::now()->subWeek()->endOfWeek()])->get();
                $s2 = $s2 -> whereBetween('updated_at',[Carbon::now()->subWeek()->startOfWeek(), Carbon::now()->subWeek()->endOfWeek()])->get();
                $s3 = $s3 -> whereBetween('updated_at',[Carbon::now()->subWeek()->startOfWeek(), Carbon::now()->subWeek()->endOfWeek()])->get();
                $s4 = $s4 -> whereBetween('updated_at',[Carbon::now()->subWeek()->startOfWeek(), Carbon::now()->subWeek()->endOfWeek()])->get();
                $s5 = $s5 -> whereBetween('updated_at',[Carbon::now()->subWeek()->startOfWeek(), Carbon::now()->subWeek()->endOfWeek()])->get();
                $s6 = $s6 -> whereBetween('updated_at',[Carbon::now()->subWeek()->startOfWeek(), Carbon::now()->subWeek()->endOfWeek()])->get();

                // awarennes count
                $awareness['Google'] = funnel::where('awareness', 'Google') -> whereBetween('updated_at',[Carbon::now()->subWeek()->startOfWeek(), Carbon::now()->subWeek()->endOfWeek()]) ->count();
                $awareness['Yandex'] = funnel::where('awareness', 'Yandex') -> whereBetween('updated_at',[Carbon::now()->subWeek()->startOfWeek(), Carbon::now()->subWeek()->endOfWeek()]) ->count();
                $awareness['Telegram'] = funnel::where('awareness', 'Telegram') -> whereBetween('updated_at',[Carbon::now()->subWeek()->startOfWeek(), Carbon::now()->subWeek()->endOfWeek()]) ->count();
                $awareness['Instagram'] = funnel::where('awareness', 'Instagram') -> whereBetween('updated_at',[Carbon::now()->subWeek()->startOfWeek(), Carbon::now()->subWeek()->endOfWeek()]) ->count();
                $awareness['Facebook'] = funnel::where('awareness', 'Facebook') -> whereBetween('updated_at',[Carbon::now()->subWeek()->startOfWeek(), Carbon::now()->subWeek()->endOfWeek()]) ->count();
                $awareness['Reklama'] = funnel::where('awareness', 'Reklama') -> whereBetween('updated_at',[Carbon::now()->subWeek()->startOfWeek(), Carbon::now()->subWeek()->endOfWeek()]) ->count();
                $awareness['Tanish-blish'] = funnel::where('awareness', 'Tanish-blish') -> whereBetween('updated_at',[Carbon::now()->subWeek()->startOfWeek(), Carbon::now()->subWeek()->endOfWeek()]) ->count();
                $awareness['Qayta-xarid'] = funnel::where('awareness', 'Qayta-xarid') -> whereBetween('updated_at',[Carbon::now()->subWeek()->startOfWeek(), Carbon::now()->subWeek()->endOfWeek()]) ->count();
                
                // total funnel MONEY
                $s1m = 0; foreach ($s1 as $i) $s1m += $i -> price;
                $s2m = 0; foreach ($s2 as $i) $s2m += $i -> price;
                $s3m = 0; foreach ($s3 as $i) $s3m += $i -> price;
                $s4m = 0; foreach ($s4 as $i) $s4m += $i -> price;
                $s5m = 0; foreach ($s5 as $i) $s5m += $i -> price;
                $s6m = 0; foreach ($s6 as $i) $s6m += $i -> price;

                $allM = array();
                array_push($allM, $s1m, $s2m, $s3m, $s4m, $s5m, $s6m);

                // total each stage funnel COUNT
                $s1t = $s1 -> count();
                $s2t = $s2 -> count();
                $s3t = $s3 -> count();
                $s4t = $s4 -> count();
                $s5t = $s5 -> count();
                $s6t = $s6 -> count();
                
                $allS = array() ;
                array_push($allS, $s1t, $s2t, $s3t, $s4t, $s5t, $s6t);

                // total stage funnel COUNT
                $s1d = $s1t + $s2t + $s3t + $s4t + $s5t + $s6t;
                $s2d = $s1d - $s1t;
                $s3d = $s1d - $s1t - $s2t;
                $s4d = $s1d - $s1t - $s2t -$s3t;
                $s5d = $s1d - $s1t - $s2t -$s3t - $s4t;
                $s6d = $s1d - $s1t - $s2t -$s3t - $s4t - $s5t;

                $allD = array() ;
                array_push($allD, $s1d, $s2d, $s3d, $s4d, $s5d, $s6d);
                // END  
                $date = $request->order;

                return view('analytics.funnel',compact('allD', 'allM', 'allS', 'awareness', 'date'));
            }

            //shu oy   
            elseif($request->order=='thisMonth'){
                $s1=$s1->whereYear('updated_at', date('Y'))->whereMonth('updated_at', Carbon::now()->month)->get();
                $s2=$s2->whereYear('updated_at', date('Y'))->whereMonth('updated_at', Carbon::now()->month)->get();
                $s3=$s3->whereYear('updated_at', date('Y'))->whereMonth('updated_at', Carbon::now()->month)->get();
                $s4=$s4->whereYear('updated_at', date('Y'))->whereMonth('updated_at', Carbon::now()->month)->get();
                $s5=$s5->whereYear('updated_at', date('Y'))->whereMonth('updated_at', Carbon::now()->month)->get();
                $s6=$s6->whereYear('updated_at', date('Y'))->whereMonth('updated_at', Carbon::now()->month)->get();

                // awarennes count
                $awareness['Google'] = funnel::where('awareness', 'Google') -> whereYear('updated_at', date('Y'))->whereMonth('updated_at', Carbon::now()->month) ->count();
                $awareness['Yandex'] = funnel::where('awareness', 'Yandex') -> whereYear('updated_at', date('Y'))->whereMonth('updated_at', Carbon::now()->month) ->count();
                $awareness['Telegram'] = funnel::where('awareness', 'Telegram') -> whereYear('updated_at', date('Y'))->whereMonth('updated_at', Carbon::now()->month) ->count();
                $awareness['Instagram'] = funnel::where('awareness', 'Instagram') -> whereYear('updated_at', date('Y'))->whereMonth('updated_at', Carbon::now()->month) ->count();
                $awareness['Facebook'] = funnel::where('awareness', 'Facebook') -> whereYear('updated_at', date('Y'))->whereMonth('updated_at', Carbon::now()->month) ->count();
                $awareness['Reklama'] = funnel::where('awareness', 'Reklama') -> whereYear('updated_at', date('Y'))->whereMonth('updated_at', Carbon::now()->month) ->count();
                $awareness['Tanish-blish'] = funnel::where('awareness', 'Tanish-blish') -> whereYear('updated_at', date('Y'))->whereMonth('updated_at', Carbon::now()->month) ->count();
                $awareness['Qayta-xarid'] = funnel::where('awareness', 'Qayta-xarid') -> whereYear('updated_at', date('Y'))->whereMonth('updated_at', Carbon::now()->month) ->count();

                // total funnel MONEY
                $s1m = 0; foreach ($s1 as $i) $s1m += $i -> price;
                $s2m = 0; foreach ($s2 as $i) $s2m += $i -> price;
                $s3m = 0; foreach ($s3 as $i) $s3m += $i -> price;
                $s4m = 0; foreach ($s4 as $i) $s4m += $i -> price;
                $s5m = 0; foreach ($s5 as $i) $s5m += $i -> price;
                $s6m = 0; foreach ($s6 as $i) $s6m += $i -> price;

                $allM = array();
                array_push($allM, $s1m, $s2m, $s3m, $s4m, $s5m, $s6m);

                // total each stage funnel COUNT
                $s1t = $s1 -> count();
                $s2t = $s2 -> count();
                $s3t = $s3 -> count();
                $s4t = $s4 -> count();
                $s5t = $s5 -> count();
                $s6t = $s6 -> count();
                
                $allS = array() ;
                array_push($allS, $s1t, $s2t, $s3t, $s4t, $s5t, $s6t);

                // total stage funnel COUNT
                $s1d = $s1t + $s2t + $s3t + $s4t + $s5t + $s6t;
                $s2d = $s1d - $s1t;
                $s3d = $s1d - $s1t - $s2t;
                $s4d = $s1d - $s1t - $s2t -$s3t;
                $s5d = $s1d - $s1t - $s2t -$s3t - $s4t;
                $s6d = $s1d - $s1t - $s2t -$s3t - $s4t - $s5t;

                $allD = array() ;
                array_push($allD, $s1d, $s2d, $s3d, $s4d, $s5d, $s6d);
                // END  
                $date = $request->order;

                return view('analytics.funnel',compact('allD', 'allM', 'allS', 'awareness', 'date'));
            }

            //o'tkan oy   
            elseif($request->order=='lastMonth'){
                
                $start = Carbon::now() -> startOfMonth() -> subMonth();
                $end = Carbon::now() -> subMonth() -> endOfMonth();
              
                $s1=$s1 -> whereBetween( 'updated_at', [$start ,$end] ) -> get();
                $s2=$s2 -> whereBetween( 'updated_at', [$start ,$end] ) -> get();
                $s3=$s3 -> whereBetween( 'updated_at', [$start ,$end] ) -> get();
                $s4=$s4 -> whereBetween( 'updated_at', [$start ,$end] ) -> get();
                $s5=$s5 -> whereBetween( 'updated_at', [$start ,$end] ) -> get();
                $s6=$s6 -> whereBetween( 'updated_at', [$start ,$end] ) -> get();

                // awarennes count
                $awareness['Google'] = funnel::where('awareness', 'Google') -> whereBetween( 'updated_at', [$start ,$end] ) ->count();
                $awareness['Yandex'] = funnel::where('awareness', 'Yandex') -> whereBetween( 'updated_at', [$start ,$end] ) ->count();
                $awareness['Telegram'] = funnel::where('awareness', 'Telegram') -> whereBetween( 'updated_at', [$start ,$end] ) ->count();
                $awareness['Instagram'] = funnel::where('awareness', 'Instagram') -> whereBetween( 'updated_at', [$start ,$end] ) ->count();
                $awareness['Facebook'] = funnel::where('awareness', 'Facebook') -> whereBetween( 'updated_at', [$start ,$end] ) ->count();
                $awareness['Reklama'] = funnel::where('awareness', 'Reklama') -> whereBetween( 'updated_at', [$start ,$end] ) ->count();
                $awareness['Tanish-blish'] = funnel::where('awareness', 'Tanish-blish') -> whereBetween( 'updated_at', [$start ,$end] ) ->count();
                $awareness['Qayta-xarid'] = funnel::where('awareness', 'Qayta-xarid') -> whereBetween( 'updated_at', [$start ,$end] ) ->count();

                // total funnel MONEY
                $s1m = 0; foreach ($s1 as $i) $s1m += $i -> price;
                $s2m = 0; foreach ($s2 as $i) $s2m += $i -> price;
                $s3m = 0; foreach ($s3 as $i) $s3m += $i -> price;
                $s4m = 0; foreach ($s4 as $i) $s4m += $i -> price;
                $s5m = 0; foreach ($s5 as $i) $s5m += $i -> price;
                $s6m = 0; foreach ($s6 as $i) $s6m += $i -> price;

                $allM = array();
                array_push($allM, $s1m, $s2m, $s3m, $s4m, $s5m, $s6m);

                // total each stage funnel COUNT
                $s1t = $s1 -> count();
                $s2t = $s2 -> count();
                $s3t = $s3 -> count();
                $s4t = $s4 -> count();
                $s5t = $s5 -> count();
                $s6t = $s6 -> count();
                
                $allS = array() ;
                array_push($allS, $s1t, $s2t, $s3t, $s4t, $s5t, $s6t);

                // total stage funnel COUNT
                $s1d = $s1t + $s2t + $s3t + $s4t + $s5t + $s6t;
                $s2d = $s1d - $s1t;
                $s3d = $s1d - $s1t - $s2t;
                $s4d = $s1d - $s1t - $s2t -$s3t;
                $s5d = $s1d - $s1t - $s2t -$s3t - $s4t;
                $s6d = $s1d - $s1t - $s2t -$s3t - $s4t - $s5t;

                $allD = array() ;
                array_push($allD, $s1d, $s2d, $s3d, $s4d, $s5d, $s6d);
                // END  
                $date = $request->order;

                return view('analytics.funnel',compact('allD', 'allM', 'allS', 'awareness', 'date'));
            }

            //shu yil   
            elseif($request->order=='thisYear'){

                $s1=$s1->whereYear('updated_at', date('Y'))->get();
                $s2=$s2->whereYear('updated_at', date('Y'))->get();
                $s3=$s3->whereYear('updated_at', date('Y'))->get();
                $s4=$s4->whereYear('updated_at', date('Y'))->get();
                $s5=$s5->whereYear('updated_at', date('Y'))->get();
                $s6=$s6->whereYear('updated_at', date('Y'))->get();

                // awarennes count
                $awareness['Google'] = funnel::where('awareness', 'Google') -> whereYear('updated_at', date('Y')) ->count();
                $awareness['Yandex'] = funnel::where('awareness', 'Yandex') -> whereYear('updated_at', date('Y')) ->count();
                $awareness['Telegram'] = funnel::where('awareness', 'Telegram') -> whereYear('updated_at', date('Y')) ->count();
                $awareness['Instagram'] = funnel::where('awareness', 'Instagram') -> whereYear('updated_at', date('Y')) ->count();
                $awareness['Facebook'] = funnel::where('awareness', 'Facebook') -> whereYear('updated_at', date('Y')) ->count();
                $awareness['Reklama'] = funnel::where('awareness', 'Reklama') -> whereYear('updated_at', date('Y')) ->count();
                $awareness['Tanish-blish'] = funnel::where('awareness', 'Tanish-blish') -> whereYear('updated_at', date('Y')) ->count();
                $awareness['Qayta-xarid'] = funnel::where('awareness', 'Qayta-xarid') -> whereYear('updated_at', date('Y')) ->count();

               // total funnel MONEY
                $s1m = 0; foreach ($s1 as $i) $s1m += $i -> price;
                $s2m = 0; foreach ($s2 as $i) $s2m += $i -> price;
                $s3m = 0; foreach ($s3 as $i) $s3m += $i -> price;
                $s4m = 0; foreach ($s4 as $i) $s4m += $i -> price;
                $s5m = 0; foreach ($s5 as $i) $s5m += $i -> price;
                $s6m = 0; foreach ($s6 as $i) $s6m += $i -> price;

                $allM = array();
                array_push($allM, $s1m, $s2m, $s3m, $s4m, $s5m, $s6m);

                // total each stage funnel COUNT
                $s1t = $s1 -> count();
                $s2t = $s2 -> count();
                $s3t = $s3 -> count();
                $s4t = $s4 -> count();
                $s5t = $s5 -> count();
                $s6t = $s6 -> count();
                
                $allS = array() ;
                array_push($allS, $s1t, $s2t, $s3t, $s4t, $s5t, $s6t);

                // total stage funnel COUNT
                $s1d = $s1t + $s2t + $s3t + $s4t + $s5t + $s6t;
                $s2d = $s1d - $s1t;
                $s3d = $s1d - $s1t - $s2t;
                $s4d = $s1d - $s1t - $s2t -$s3t;
                $s5d = $s1d - $s1t - $s2t -$s3t - $s4t;
                $s6d = $s1d - $s1t - $s2t -$s3t - $s4t - $s5t;

                $allD = array() ;
                array_push($allD, $s1d, $s2d, $s3d, $s4d, $s5d, $s6d);
                // END  
                $date = $request->order;

                return view('analytics.funnel',compact('allD', 'allM', 'allS', 'awareness', 'date'));
            }

            //o'tkan yil   
            elseif($request->order=='lastYear'){

                $s1=$s1->whereYear('updated_at', date('Y')-1)->get();
                $s2=$s2->whereYear('updated_at', date('Y')-1)->get();
                $s3=$s3->whereYear('updated_at', date('Y')-1)->get();
                $s4=$s4->whereYear('updated_at', date('Y')-1)->get();
                $s5=$s5->whereYear('updated_at', date('Y')-1)->get();
                $s6=$s6->whereYear('updated_at', date('Y')-1)->get();

                // awarennes count
                $awareness['Google'] = funnel::where('awareness', 'Google') -> whereYear('updated_at', date('Y')-1) ->count();
                $awareness['Yandex'] = funnel::where('awareness', 'Yandex') -> whereYear('updated_at', date('Y')-1) ->count();
                $awareness['Telegram'] = funnel::where('awareness', 'Telegram') -> whereYear('updated_at', date('Y')-1) ->count();
                $awareness['Instagram'] = funnel::where('awareness', 'Instagram') -> whereYear('updated_at', date('Y')-1) ->count();
                $awareness['Facebook'] = funnel::where('awareness', 'Facebook') -> whereYear('updated_at', date('Y')-1) ->count();
                $awareness['Reklama'] = funnel::where('awareness', 'Reklama') -> whereYear('updated_at', date('Y')-1) ->count();
                $awareness['Tanish-blish'] = funnel::where('awareness', 'Tanish-blish') -> whereYear('updated_at', date('Y')-1) ->count();
                $awareness['Qayta-xarid'] = funnel::where('awareness', 'Qayta-xarid') -> whereYear('updated_at', date('Y')-1) ->count();

                // total funnel MONEY
                $s1m = 0; foreach ($s1 as $i) $s1m += $i -> price;
                $s2m = 0; foreach ($s2 as $i) $s2m += $i -> price;
                $s3m = 0; foreach ($s3 as $i) $s3m += $i -> price;
                $s4m = 0; foreach ($s4 as $i) $s4m += $i -> price;
                $s5m = 0; foreach ($s5 as $i) $s5m += $i -> price;
                $s6m = 0; foreach ($s6 as $i) $s6m += $i -> price;

                $allM = array();
                array_push($allM, $s1m, $s2m, $s3m, $s4m, $s5m, $s6m);

                // total each stage funnel COUNT
                $s1t = $s1 -> count();
                $s2t = $s2 -> count();
                $s3t = $s3 -> count();
                $s4t = $s4 -> count();
                $s5t = $s5 -> count();
                $s6t = $s6 -> count();
                
                $allS = array() ;
                array_push($allS, $s1t, $s2t, $s3t, $s4t, $s5t, $s6t);

                // total stage funnel COUNT
                $s1d = $s1t + $s2t + $s3t + $s4t + $s5t + $s6t;
                $s2d = $s1d - $s1t;
                $s3d = $s1d - $s1t - $s2t;
                $s4d = $s1d - $s1t - $s2t -$s3t;
                $s5d = $s1d - $s1t - $s2t -$s3t - $s4t;
                $s6d = $s1d - $s1t - $s2t -$s3t - $s4t - $s5t;

                $allD = array() ;
                array_push($allD, $s1d, $s2d, $s3d, $s4d, $s5d, $s6d);
                // END  
                $date = $request->order;

                return view('analytics.funnel',compact('allD', 'allM', 'allS', 'awareness', 'date'));
            }

            //hammasi
            elseif($request->order=='all'){

                $s1 = $s1 -> get();
                $s2 = $s2 -> get();
                $s3 = $s3 -> get();
                $s4 = $s4 -> get();
                $s5 = $s5 -> get();
                $s6 = $s6 -> get();

                // awarennes count
                $awareness['Google'] = funnel::where('awareness', 'Google') -> count();
                $awareness['Yandex'] = funnel::where('awareness', 'Yandex') -> count();
                $awareness['Telegram'] = funnel::where('awareness', 'Telegram') -> count();
                $awareness['Instagram'] = funnel::where('awareness', 'Instagram') -> count();
                $awareness['Facebook'] = funnel::where('awareness', 'Facebook') -> count();
                $awareness['Reklama'] = funnel::where('awareness', 'Reklama') -> count();
                $awareness['Tanish-blish'] = funnel::where('awareness', 'Tanish-blish') -> count();
                $awareness['Qayta-xarid'] = funnel::where('awareness', 'Qayta-xarid') -> count();

                // total funnel MONEY
                $s1m = 0; foreach ($s1 as $i) $s1m += $i -> price;
                $s2m = 0; foreach ($s2 as $i) $s2m += $i -> price;
                $s3m = 0; foreach ($s3 as $i) $s3m += $i -> price;
                $s4m = 0; foreach ($s4 as $i) $s4m += $i -> price;
                $s5m = 0; foreach ($s5 as $i) $s5m += $i -> price;
                $s6m = 0; foreach ($s6 as $i) $s6m += $i -> price;

                $allM = array();
                array_push($allM, $s1m, $s2m, $s3m, $s4m, $s5m, $s6m);

                // total each stage funnel COUNT
                $s1t = $s1 -> count();
                $s2t = $s2 -> count();
                $s3t = $s3 -> count();
                $s4t = $s4 -> count();
                $s5t = $s5 -> count();
                $s6t = $s6 -> count();
                
                $allS = array() ;
                array_push($allS, $s1t, $s2t, $s3t, $s4t, $s5t, $s6t);

                // total stage funnel COUNT
                $s1d = $s1t + $s2t + $s3t + $s4t + $s5t + $s6t;
                $s2d = $s1d - $s1t;
                $s3d = $s1d - $s1t - $s2t;
                $s4d = $s1d - $s1t - $s2t -$s3t;
                $s5d = $s1d - $s1t - $s2t -$s3t - $s4t;
                $s6d = $s1d - $s1t - $s2t -$s3t - $s4t - $s5t;

                $allD = array() ;
                array_push($allD, $s1d, $s2d, $s3d, $s4d, $s5d, $s6d);
                // END  
                $date = $request->order;

                return view('analytics.funnel',compact('allD', 'allM', 'allS', 'awareness', 'date'));
            }
            
        }

        $s1=$s1->whereDate('updated_at', '>=', Carbon::now()->startOfWeek())->get();
        $s2=$s2->whereDate('updated_at', '>=', Carbon::now()->startOfWeek())->get();
        $s3=$s3->whereDate('updated_at', '>=', Carbon::now()->startOfWeek())->get();
        $s4=$s4->whereDate('updated_at', '>=', Carbon::now()->startOfWeek())->get();
        $s5=$s5->whereDate('updated_at', '>=', Carbon::now()->startOfWeek())->get();
        $s6=$s6->whereDate('updated_at', '>=', Carbon::now()->startOfWeek())->get();

        // awarennes count
        $awareness['Google'] = funnel::where('awareness', 'Google') -> whereDate('updated_at', '>=', Carbon::now()->startOfWeek()) ->count();
        $awareness['Yandex'] = funnel::where('awareness', 'Yandex') -> whereDate('updated_at', '>=', Carbon::now()->startOfWeek()) ->count();
        $awareness['Telegram'] = funnel::where('awareness', 'Telegram') -> whereDate('updated_at', '>=', Carbon::now()->startOfWeek()) ->count();
        $awareness['Instagram'] = funnel::where('awareness', 'Instagram') -> whereDate('updated_at', '>=', Carbon::now()->startOfWeek()) ->count();
        $awareness['Facebook'] = funnel::where('awareness', 'Facebook') -> whereDate('updated_at', '>=', Carbon::now()->startOfWeek()) ->count();
        $awareness['Reklama'] = funnel::where('awareness', 'Reklama') -> whereDate('updated_at', '>=', Carbon::now()->startOfWeek()) ->count();
        $awareness['Tanish-blish'] = funnel::where('awareness', 'Tanish-blish') -> whereDate('updated_at', '>=', Carbon::now()->startOfWeek()) ->count();
        $awareness['Qayta-xarid'] = funnel::where('awareness', 'Qayta-xarid') -> whereDate('updated_at', '>=', Carbon::now()->startOfWeek()) ->count();

        // total funnel MONEY
        $s1m = 0; foreach ($s1 as $i) $s1m += $i -> price;
        $s2m = 0; foreach ($s2 as $i) $s2m += $i -> price;
        $s3m = 0; foreach ($s3 as $i) $s3m += $i -> price;
        $s4m = 0; foreach ($s4 as $i) $s4m += $i -> price;
        $s5m = 0; foreach ($s5 as $i) $s5m += $i -> price;
        $s6m = 0; foreach ($s6 as $i) $s6m += $i -> price;

        $allM = array();
        array_push($allM, $s1m, $s2m, $s3m, $s4m, $s5m, $s6m);

        // total each stage funnel COUNT
        $s1t = $s1 -> count();
        $s2t = $s2 -> count();
        $s3t = $s3 -> count();
        $s4t = $s4 -> count();
        $s5t = $s5 -> count();
        $s6t = $s6 -> count();
        
        $allS = array() ;
        array_push($allS, $s1t, $s2t, $s3t, $s4t, $s5t, $s6t);

        // total stage funnel COUNT
        $s1d = $s1t + $s2t + $s3t + $s4t + $s5t + $s6t;
        $s2d = $s1d - $s1t;
        $s3d = $s1d - $s1t - $s2t;
        $s4d = $s1d - $s1t - $s2t -$s3t;
        $s5d = $s1d - $s1t - $s2t -$s3t - $s4t;
        $s6d = $s1d - $s1t - $s2t -$s3t - $s4t - $s5t;

        $allD = array() ;
        array_push($allD, $s1d, $s2d, $s3d, $s4d, $s5d, $s6d);
        // END  
        $date = $request->order;

        return view('analytics.funnel',compact('allD', 'allM', 'allS', 'awareness', 'date'));
    }
}