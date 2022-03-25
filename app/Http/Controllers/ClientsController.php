<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Client;
use App\Models\Company;
use App\Models\Master;
use App\Models\Sales;
use App\Models\SaleProduct;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Funnel;

class ClientsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clients= Client::orderBy('created_at','desc')->get();
        $companies= Company::orderBy('id')->get();
        $masters= Master::orderBy('id')->get();
        return view('clients.index', compact('clients','companies', 'masters'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    { 
        $companies= company::orderBy('company')->get();
        $masters= master::orderBy('master')->get();
        return view('clients.create',compact('companies', 'masters'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // functions for validations
        function ctype($type, $is){
            if($type==$is){
                return 'required';
            }else return '';};
    
        function phone2($request){
            if ($request!==NULL){
                return 'digits:9|unique:clients,phone1||unique:clients,phone2';
            } else  return '';};
    
        function adress($request){
            if ($request!==NULL){
                return 'max:100';
            } else  return '';};
        
        //validation
        $data = $request->validate([
            'type'=>'required',
            'language'=>'',
            'company_code'=>ctype($request->type,'Kompaniya xodimi' ),
            'master_code'=>ctype($request->type,'Usta' ),
            'name'=>"required|regex:/^[a-zA-Z']+$/u|min:2|max:30",
            'surname'=>"nullable|regex:/^[a-zA-Z']+$/u|min:2|max:30",
            'dateOfBirth'=>'',
            'gender'=>'',
            'phone1'=>'required|digits:9|unique:clients,phone1||unique:clients,phone2',
            'phone2'=>phone2($request->phone2),
            'address'=>adress($request->address),
            'region'=>'required',
            'feedback'=>'max:100'
        ],[ 
            'type.required' => 'Mijoz kimligini tanlang!',
            'name.required'=>'Mijoz ismini kiriting!',
            'name.regex'=>"Mijoz ismi faqat lotin alfavitidan va ' belgisidan tashkil topishi mumkin!",
            'name.max'=>"Mijoz ismi 30 ta harfdan kam bo'lsin!",
            'name.min'=>"Mijoz ismi 2 ta harfdan ko'p bo'lsin!",
            'surname.regex'=>"Mijoz familiyasi faqat lotin alfavitidan va ' belgisidan tashkil topishi mumkin!",
            'surname.max'=>"Mijoz familiyasi 30 ta harfdan kam bo'lsin!",
            'surname.min'=>"Mijoz familiyasi 2 ta harfdan ko'p bo'lsin!",
            'phone1.required'=>"Telefon raqamni kiritish majburiy!",
            'phone1.digits'=>"Telefon raqam faqat 9 ta sondan iborat bo'lishi kerak!",
            'phone1.unique'=>"Telefon raqam bazada mavjud, iltimos boshqa raqamni kiriting!",
            'phone2.required'=>"Telefon raqamni kiritish majburiy!",
            'phone2.digits'=>"Telefon raqam faqat 9 ta sondan iborat bo'lishi kerak!",
            'phone2.unique'=>"Telefon raqam bazada mavjud, iltimos boshqa raqamni kiriting!",
            'company_code.required'=>"Kompaniya nomini tanlang!",
            'master_code.required'=>"Usta turini tanlang!",
            'region.required'=>"Viloyatni tanlang!",
            'address.max'=>"Manzil 100 ta belgidan oshmasligi kerak!",
            'feedback.max'=>"Izoh 100 ta belgidan oshmasligi kerak!"
        ]);

      

        // save data
        $client = new Client;
        $client->company_code = $data['company_code'];
        $client->master_code = $data['master_code']; 
        $client->type = $data['type'];
        $client->language = $data['language'];
        $client->name = $data['name'];
        $client->surname = $data['surname'];
        $client->dateOfBirth = $data['dateOfBirth'];
        $client->gender = $data['gender'];
        $client->phone1 = $data['phone1'];
        $client->phone2 = $data['phone2'];
        $client->region = $data['region'];
        $client->address = $data['address'];
        $client->feedback = $data['feedback'];
        $client->save();

        return back()->with('message', 'Mijoz muvafaqqiyatli kiritildi!');
        
    
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $client = client::find($id);
        $company = company::find($client->company_code);
        $company? $company=$company->company  : '';
        $master = master::find($client->master_code);
        $master? $master=$master->master  : '';
        $sales = sales::where('client_id' ,$client->id )->orderByDesc('created_at')->get();
        $a=[];
        foreach($sales as $sale){ 
            $a[]+=$sale->id;
        }
        $saleProducts = saleProduct::whereIn('sale_id', $a)->orderBy('created_at')->get();

        $b=[];
        foreach($saleProducts as $saleProduct){ 
            $b[]+=$saleProduct->product_id;
        }
        $products = product::whereIn('id', $b)->orderBy('created_at')->get();
        $categories = category::all();
        $brands = brand::all();
        $funnels = funnel::where('client_id', $id)->get();
        return view('clients.show',compact('client', 'company','master', 'sales','saleProducts','products','categories','brands', 'funnels'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
        $companies = Company::get();
        $masters = Master::get();
        $client = Client::find($id);
                
        return view('clients.edit',[
            'client'=>$client,
            'companies'=>$companies,
            'masters'=>$masters
        ]);
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
        //client from id
        $client = Client::find($id);

        //functions for phone1
        $phone1;
            if($request->phone1==$client->phone1) { $phone1 ='';} 
            else {$phone1 = 'required|digits:9|unique:clients,phone1|unique:clients,phone2';}

        //function for phone2
        $phone2;
            if($request->phone2==$client->phone2) {$phone2 = '';} 
            elseif($request->phone2==NULL) {$phone2 = '';}
            else {$phone2 = 'required|digits:9|unique:clients,phone1||unique:clients,phone2';}
        
        //function to check client type - uy egas, kompaniya xodimi, usta
        function ctype($type, $is){
            if($type==$is){ 
                return 'required';
            }else return '';
        };

        //function to validate if the adress has
        function address($request){
            if ($request!==NULL){
                return 'max:100';
            } else  return '';
        };
        $address=address($request->address);
        //validation
        $data = $request->validate([
            'type'=>'required',
            'language'=>'',
            'company_code'=>ctype($request->type,'Kompaniya xodimi' ),
            'master_code'=>ctype($request->type,'Usta' ),
            'name'=>"required|regex:/^[a-zA-Z']+$/u|min:2|max:30",
            'surname'=>"nullable|regex:/^[a-zA-Z']+$/u|min:2|max:30",
            'dateOfBirth'=>'',
            'gender'=>'',
            'phone1'=>$phone1,
            'phone2'=>$phone2,
            'address'=>$address,
            'region'=>'required',
            'feedback'=>'max:100'
        ],[ 
            'type.required' => 'Mijoz kimligini tanlang!',
            'name.required'=>'Mijoz ismini kiriting!',
            'name.regex'=>"Mijoz ismi faqat lotin alfavitidan va ' belgisidan tashkil topishi mumkin!",
            'name.max'=>"Mijoz ismi 30 ta harfdan kam bo'lsin!",
            'name.min'=>"Mijoz ismi 2 ta harfdan ko'p bo'lsin!",
            'surname.required'=>'Mijoz familiyasini kiriting!',
            'surname.regex'=>"Mijoz familiyasi faqat lotin alfavitidan va ' belgisidan tashkil topishi mumkin!",
            'surname.max'=>"Mijoz familiyasi 30 ta harfdan kam bo'lsin!",
            'surname.min'=>"Mijoz familiyasi 2 ta harfdan ko'p bo'lsin!",
            'phone1.required'=>"Telefon raqamni kiritish majburiy!",
            'phone1.digits'=>"Telefon raqam faqat 9 ta sondan iborat bo'lishi kerak!",
            'phone1.unique'=>"Telefon raqam bazada mavjud, iltimos boshqa raqamni kiriting!",
            'phone2.required'=>"Telefon raqamni kiritish majburiy!",
            'phone2.digits'=>"Telefon raqam faqat 9 ta sondan iborat bo'lishi kerak!",
            'phone2.unique'=>"Telefon raqam bazada mavjud, iltimos boshqa raqamni kiriting!",
            'company_code.required'=>"Kompaniya nomini tanlang!",
            'master_code.required'=>"Usta turini tanlang!",
            'region.required'=>"Viloyatni tanlang!",
            'address.max'=>"Manzil 100 ta belgidan oshmasligi kerak!",
            'feedback.max'=>"Izoh 100 ta belgidan oshmasligi kerak!"
        ]);

        //removing company_code and _master_code if they are not exist
        if($data['type']=='Uy egasi'){$data['company_code']=NULL; $data['master_code']=NULL;}
        elseif($data['type']=='Kompaniya xodimi')  $data['master_code']=NULL;
        else $data['company_code']=NULL;

        //updating data
        $client->company_code = $data['company_code'];
        $client->master_code = $data['master_code']; 
        $client->type = $data['type'];
        $client->language = $data['language'];
        $client->name = $data['name'];
        $client->surname = $data['surname'];
        $client->dateOfBirth = $data['dateOfBirth'];
        $client->gender = $data['gender'];
        $client->phone1 = $data['phone1'];
        $client->phone2 = $data['phone2'];
        $client->region = $data['region'];
        $client->address = $data['address'];
        $client->feedback = $data['feedback'];
        $client->update();
        return redirect()->route('client-base.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
            $client = Client::find($id);
            $client->delete();
            return redirect()->route('client-base.index');
    }




}