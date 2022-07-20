<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Company;
use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use App\Repositories\EmployeeRepository;
use App\Repositories\CompanyRepository;
use DataTables;


class EmployeeController extends Controller
{
    
    protected $repository;
    protected $cmprepository;

    public function __construct(EmployeeRepository $employeeRepository, CompanyRepository $companyRepository) 
    {
        $this->repository = $employeeRepository;
        $this->companyRepository =  $companyRepository;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
  
        if ($request->ajax()) {
            $data = $this->repository->getAllEmployees();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $btn = '<form method="post" action="/employees/'.$row->id.'">
                        <input type="hidden" name="_method" value="delete"> 
                        <input type="hidden" name="_token" value="'.csrf_token().'">
                        <button type="submit" class="fabutton"><i class="far fa-trash-alt"></i></button>
                    </form>';
                    $btn .= '<br><form method="get" action="/employees/'.$row->id.'/edit">
                    <input type="hidden" name="_token" value="'.csrf_token().'">
                    <button type="submit" class="fabutton" ><i class="far fa-edit"></i></button>
                    </form>'; 

                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
          
        return view('employee.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $companies =  $this->companyRepository->getAllCompanies(); 
        return view('employee.create', compact('companies', $companies));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreEmployeeRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreEmployeeRequest $request)
    {
        $employeeDetails = [
            "first_name" => $request->first_name,
            "last_name" => $request->last_name,
            "email" => $request->email,
            "phone" => $request->phone,
            "company_id" => $request->company_id
        ];
        try {      
            $this->repository->createEmployee($EmployeeDetails) ;
        } catch (Exception $exception) {
            return back()->with('error',"You are not able to access");
        }
        return redirect("/employees")->with('success','Successfully Created. ');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function show(Employee $employee)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function edit(Employee $employee)
    {
        $companies = $this->companyRepository->getAllCompanies();
        return view('employee.edit', compact('employee', 'companies'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateEmployeeRequest  $request
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateEmployeeRequest $request, Employee $employee)
    {
        $employeeDetails = [
            "first_name" => $request->first_name,
            "last_name" => $request->last_name,
            "email" => $request->email,
            "phone" => $request->phone,
            "company_id" => $request->company_id
        ];
        try {
            $this->repository->updateEmployee($employee->id, $employeeDetails);
        } catch (Exception $exception) {
             return back()->with('error',"You are not able to access");
         }
        
        return redirect("/employees")->with('success','Successfully Updated. '); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employee $employee)
    {
        $this->repository->deleteEmployee($employee->id);
        return redirect("/employees")->with('success','Successfully deleted. ');
    }
}