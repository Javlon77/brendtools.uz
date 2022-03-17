<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use App\Models\User;

class TasksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $myprofile = auth()->user();
        $users = User::all();
        return view('tasks.index',compact('myprofile', 'users'));
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
        $data = $request->validate([
            'task_header'=> '',
            'task'=>'',
            'user_id' => '',
            'deadline_at' => ''
        ]);

        $data['tasker_id']= auth()->user()->id;

        if($data['deadline_at'] !== NULL) {
            $data['deadline_at']= \Carbon\Carbon::createFromFormat('Y-m-d', $data['deadline_at'])->endOfDay()->toDateTimeString();
        }

        
        $task = task::create($data);
     
        return redirect()->back()->with('success', 'Vazifa muvafaqqiyatli saqlandi');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $header ;
        if(auth()->user()->id==$id){
            $header = 'Mening vazifalarim';
        }
        elseif($id==0){
            $header = 'Umumiy vazifalar';
        }
        else $header = user::find($id)->name.'ning vazifalari';
        
        $ongoing = task::where('user_id', $id)->where('status', 0)->get();
        $done = task::where('user_id', $id)->where('status', 1)->get();
        $users = user::all();
        return view('tasks.show', compact( 'header', 'ongoing', 'done', 'users'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function edit(Task $task)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        $task = task::find($id);
        $task['status'] = 1;
        $task -> save();
        // $task
        return redirect() -> back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        $task -> delete(); 
        return redirect() -> back();
    }
}