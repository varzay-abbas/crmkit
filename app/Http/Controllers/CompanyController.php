<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Http\Requests\StoreCompanyRequest;
use App\Http\Requests\UpdateCompanyRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use App\Mail\SendEmail;
use Illuminate\Support\Facades\Mail;
use App\Repositories\CompanyRepository;
use DataTables;


class CompanyController extends Controller
{
    
    protected $repository;

    public function __construct(CompanyRepository $companyRepository) 
    {
        $this->repository = $companyRepository;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = $this->repository->getAllCompanies();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('clogo', function ($row) {
                        $url = asset('storage/'.$row->logo);
                        return '<img src="'.$url.'" width="50" height="50"  >';
                    })->addColumn('action', function($row){
                            $btn = '<form method="post" action="/companies/'.$row->id.'">
                            <input type="hidden" name="_method" value="delete"> 
                            <input type="hidden" name="_token" value="'.csrf_token().'">
                            <button type="submit" class="fabutton"><i class="far fa-trash-alt"></i></button>
                        </form>';
                          $btn .= '<form method="get" action="/companies/'.$row->id.'/edit">
                          <input type="hidden" name="_token" value="'.csrf_token().'">
                          <button type="submit" class="fabutton" ><i class="far fa-edit"></i></button>
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
            $fileName = time().'.'.$request->file('logo')->extension();  
            $request->file('logo')->storeAs('public', $fileName); 
            $companyDetails = [
                "name" => $request->name,
                "email" => $request->email,
                "website" => $request->website,
                "logo" => $fileName
            ];
            $this->repository->createCompany($companyDetails) ;

            //can be set here for other emails
            $reveiverEmailAddress = "abbas23481@gmail.com"; //Might be mailgun authorized in mailgun for freeplan
            @Mail::to($reveiverEmailAddress)->send(new SendEmail($companyDetails));
           // $reveiverEmailAddress = $request->email; 
            //company be admin but need to be authorized in mailgun as it is free plan
            //@Mail::to($reveiverEmailAddress)->send(new SendEmail($details));

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
       
        try {       
            if($request->hasFile('logo')) {
               $fileName = time().'.'.$request->file('logo')->extension();  
               $request->file('logo')->storeAs('public', $fileName); 
            } else  $fileName = $company->logo;      
            
            $companyDetails = [
                "name" => $request->name,
                "email" => $request->email,
                "website" => $request->website,
                "logo" => $fileName
            ];
            $this->repository->updateCompany($company->id, $companyDetails )  ;

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
        $this->repository->deleteCompany($company->id);
        return redirect("/companies")->with('success','Successfully deleted. ');
    }
}