<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Http\Requests\StoreCompanyRequest;
use App\Http\Requests\UpdateCompanyRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use App\Mail\SendEmail;
use Illuminate\Support\Facades\Mail;
use DataTables;


class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Company::select('*');
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('clogo', function ($row) {
                        $url = asset('storage/'.$row->logo);
                        return '<img src="'.$url.'" class="" width="20"  >';
                    })->addColumn('action', function($row){
                            $btn = '<form method="post" action="/companies/'.$row->id.'">
                            <input type="hidden" name="_method" value="delete"> 
                            <input type="hidden" name="_token" value="'.csrf_token().'">
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>';
                          $btn .= '<br><form method="get" action="/companies/'.$row->id.'/edit">
                          <input type="hidden" name="_token" value="'.csrf_token().'">
                          <button type="submit" class="btn btn-danger btn-sm">Edit</button>
                          </form>';
                            return $btn;
                    })
                    ->rawColumns(['clogo','action'])
                    ->make(true);
        }
          
        return view('company.index');
    }
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('company.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCompanyRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCompanyRequest $request)
    {

        try {        
            $company = new Company;
            $company->name = $request->name;
            $company->email = $request->email;
            $company->website = $request->website;
            $fileName = time().'.'.$request->file('logo')->extension();  
            $request->file('logo')->storeAs('public', $fileName); 
            $company->logo = $fileName;
            $company->save();
            $details = [
                'name' => $request->name,
                'email' => $request->email,
                'website' => $request->website
            ];
            $reveiverEmailAddress = "aus234@gmail.com";
            @Mail::to($reveiverEmailAddress)->send(new SendEmail($details));
        } catch (Exception $exception) {
            return back()->with('error',"You are not able to access");
        }

        return redirect("/companies")->with('success','Successfully Created. '); 
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function show(Company $company)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function edit(Company $company)
    {
        return view('company.edit', compact('company'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCompanyRequest  $request
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCompanyRequest $request, Company $company)
    {
        $companyObj = Company::find($company->id);
        try {       
            if($request->hasFile('logo')) {
               $fileName = time().'.'.$request->file('logo')->extension();  
               $request->file('logo')->storeAs('public', $fileName); 
               $companyObj->logo = $fileName;
            }         
            $companyObj->name = $request->name;
            $companyObj->email = $request->email;
            $companyObj->website = $request->website; 
            $companyObj->save();
        } catch (Exception $exception) {
             return back()->with('error',"You are not able to access");
         }

        return redirect("/companies")->with('success','Successfully Updated. '); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company  $company)
    {
        unlink(storage_path('app/public/'.$company->logo));
        $company->delete();
        return redirect("/companies");
    }
}