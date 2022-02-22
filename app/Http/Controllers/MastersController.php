<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Master;
use Illuminate\Support\Facades\Validator;

class MastersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $masters = master::orderBy('master')->get();
        return view('masters.index', compact('masters'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    { 
        $masters= Master::orderBy('master')->get();
        return view('masters.create', compact('masters'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    { 
        if($request->ajax()){
            $validator = Validator::make($request->all(),[
                'master'=>'required|unique:masters,master'
            ],
            [
                'master.required'=>'Usta turini kiriting!',
                'master.unique'=>"Ushbu usta turi bazada mavjud!!!"
            ]);
            if($validator ->fails()){
                return response()->json([
                    'status'=>400,
                    'errors'=>$validator->messages(),
                ]);
            }
            else {
                $master = new master;
                $master ->master = $request->input('master');
                $master->save();
                return response()->json([
                    'master'=> $master ->master,
                    'id'=> $master ->id
                ]);
            }
        }
        else{
            $data = $request->validate([
                'master'=>'required|unique:masters,master'
            ],
            [
                'master.required'=>'Usta turini kiriting!',
                'master.unique'=>"Ushbu usta turi bazada mavjud!!!"
            ]);
            master::create($data);
            return redirect()->back()->with('message', '"'.$request->master . '"' .' nomli usta turi bazaga muvaffaqiyatli kiritildi!');
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
        $master = master::find($id);  
        return view('masters.edit',compact('master'));
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
        $master = master::find($id);
        $a=strtolower($request->master);
        $b=strtolower($master->master);
        
        if($a==$b){
            $data = $request->validate([
                'master'=>''
            ]);
            $master->update($data);
            return redirect()->route('masters-base.index');
        }

        $data = $request->validate([
            'master'=>'required|unique:masters,master'
        ],
        [
            'master.required'=>'Usta turini kiriting!',
            'master.unique'=>"Ushbu usta turi bazada mavjud!!!"
        ]);
        $master->update($data);
        return redirect()->route('masters-base.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $master = master::find($id);
        $master->delete();
        return redirect()->route('masters-base.index');
    }
}
