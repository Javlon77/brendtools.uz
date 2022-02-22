<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Company;

class CompaniesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $companies = Company::orderBy('company')->get();
        return view('companies.index', compact('companies'));
     
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('companies.create');
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
            $validator =Validator::make($request->all(),[
                'company'=>'required|unique:companies,company'
            ],
            [
                'company.required'=>'Kompaniya nomini kiriting!',
                'company.unique'=>"Ushbu Kompaniya bazada mavjud!!!"
            ]);
            if($validator ->fails()){
                return response()->json([
                    'status'=>400,
                    'errors'=>$validator->messages(),
                ]);
                
            }
            else {
                $company = new Company;
                $company ->company = $request->input('company');
                $company->save();
    
                
                return response()->json([
                    'company'=> $company ->company,
                     'id'=> $company ->id
                ]);
            }
        }
        else{
            $data = $request->validate([
                'company'=>'required|unique:companies,company'
            ],
            [
                'company.required'=>'Kompaniya nomini kiriting!',
                'company.unique'=>"Ushbu Kompaniya bazada mavjud!!!"
            ]);
            company::create($data);
            return redirect()->back()->with('message', '"'.$request->company . '"' .' kompaniyasi bazaga muvaffaqiyatli kiritildi!');
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
        $company = company::find($id);  
        return view('companies.edit',compact('company'));
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
        $company = company::find($id);
        $a=strtolower($request->company);
        $b=strtolower($company->company);
        if($a==$b){
            $data = $request->validate([
                'company'=>''
            ]);
            $company->update($data);
            return redirect()->route('companies-base.index');
        }
        
        $data = $request->validate([
            'company'=>'required|unique:companies,company'
        ],
        [
            'company.required'=>'Kompaniya nomini kiriting!',
            'company.unique'=>"Ushbu Kompaniya bazada mavjud!!!"
        ]);
        $company->update($data);
        return redirect()->route('companies-base.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $company = company::find($id);
        $company->delete();
        return redirect()->route('companies-base.index');
    }
}
